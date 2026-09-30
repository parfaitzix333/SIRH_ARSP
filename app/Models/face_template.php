<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class face_template extends Model
{
    protected $fillable = [
        'employe_id',
        'face_embedding',
        'annee_id',
    ];

    protected $casts = [
        'employe_id' => 'integer',
        'annee_id'   => 'integer',
    ];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
    /**
     * Convertit un tableau PHP de 512 floats en BLOB 2048 octets.
     */
    public static function floatsToBlob(array $floats): string
    {
        if (count($floats) !== 512) {
            throw new \InvalidArgumentException(
                "Attendu 512 floats, reçu " . count($floats)
            );
        }

        // 'g' = float32 little-endian
        $blob = pack('g*', ...$floats);

        if (strlen($blob) !== 2048) {
            throw new \RuntimeException(
                "Taille BLOB invalide : " . strlen($blob)
            );
        }

        return $blob;
    }

    /**
     * Convertit un BLOB 2048 octets en tableau de 512 floats.
     */
    public static function blobToFloats(string $blob): array
    {
        if (strlen($blob) !== 2048) {
            throw new \RuntimeException(
                "BLOB attendu de 2048 octets, reçu " . strlen($blob)
            );
        }

        return array_values(unpack('g*', $blob));
    }

    /**
     * Accès pratique : $template->embedding_as_array
     */
    public function getEmbeddingAsArrayAttribute(): array
    {
        return self::blobToFloats($this->face_embedding);
    }
}
