@php
    $columns = $columns ?? [];
    $fields = $fields ?? [];
    $resource = $resource ?? null;
    $fileRoute = $fileRoute ?? 'communiques.file';
    $formTitle = $formTitle ?? $title;
    $hasAnneeField = collect($fields)->contains('key', 'annee_id');
    $fieldOptions = function (array $field) {
        if (!isset($field['options'])) {
            return collect();
        }

        return is_string($field['options'])
            ? match ($field['options']) {
                'annees' => \App\Models\annee::orderByDesc('annee')->get(),
                'employes' => \App\Models\employe::orderBy('nom')->get(),
                'services' => \App\Models\service::orderBy('nom_service')->get(),
                'domaines' => \App\Models\service::query()
                    ->whereNotNull('domaine')
                    ->where('domaine', '<>', '')
                    ->select('domaine')
                    ->distinct()
                    ->orderBy('domaine')
                    ->get()
                    ->map(
                        fn($service) => [
                            'value' => $service->domaine,
                            'label' => $service->domaine,
                        ],
                    ),
                'grades' => \App\Models\grade::orderBy('designation')->get(),
                'categories' => \App\Models\categorie::orderBy('designation')->get(),
                'postes' => \App\Models\poste::orderBy('intitule')->get(),
                'sanctions' => \App\Models\sanction::orderBy('designation')->get(),
                'conges' => \App\Models\conge::orderBy('designation')->get(),
                'formations' => \App\Models\formation::orderBy('intitule')->get(),
                'users' => \App\Models\User::orderBy('name')->get(),
                default => collect(),
            }
            : collect($field['options']);
    };
@endphp

<style>
    .resource-actions {
        display: inline-flex;
        gap: .4rem;
        white-space: nowrap;
    }

    .resource-actions form {
        display: inline-flex;
        margin: 0;
    }

    .resource-actions .btn {
        width: 34px;
        height: 34px;
        padding: 0;
    }

    .resource-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .resource-form-grid .full-width {
        grid-column: 1 / -1;
    }

    @media (max-width: 576px) {
        .resource-form-grid {
            grid-template-columns: 1fr;
        }

        .resource-form-grid .full-width {
            grid-column: auto;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">{{ $title }}</h3>
            <p class="text-muted mb-0">Données de l'année sélectionnée</p>
        </div>
        @if ($resource && $fields)
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createResourceModal">
                <i class="fas fa-plus me-1"></i> Ajouter
            </button>
        @endif
        <span class="badge bg-primary-subtle text-primary fs-6">
            {{ $items->count() }} élément(s)
        </span>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 p-3">
            <div class="input-group" style="max-width: 360px;">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search"></i>
                </span>
                <input type="search" class="form-control border-start-0 resource-search" placeholder="Rechercher..."
                    aria-label="Rechercher dans {{ $title }}">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 resource-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        @foreach ($columns as $column)
                            <th>{{ $column['label'] }}</th>
                        @endforeach
                        @if ($hasAnneeField)
                            <th>Année</th>
                        @endif
                        @if ($resource && $fields)
                            <th class="text-center">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            @foreach ($columns as $column)
                                @php
                                    $value = data_get($item, $column['key']);
                                @endphp
                                <td>
                                    @if (($column['type'] ?? null) === 'status')
                                        @php
                                            $statusClass = match (strtolower((string) $value)) {
                                                'entrée',
                                                'entree',
                                                'active',
                                                'validee',
                                                'soumise',
                                                'oui',
                                                'present',
                                                'in',
                                                'entrant'
                                                    => 'bg-success-subtle text-success',
                                                'sortie',
                                                'sortie',
                                                'inactive',
                                                'refusee',
                                                'non',
                                                'absent',
                                                'out',
                                                'sortant'
                                                    => 'bg-danger-subtle text-danger',
                                                default => 'bg-secondary-subtle text-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ $value ?? '-' }}
                                        </span>
                                    @elseif (($column['type'] ?? null) === 'computed_status' && $item->date_publication)
                                        @php
                                            $publicationDate = \Illuminate\Support\Carbon::parse(
                                                $item->date_publication,
                                            );
                                            $isPublished = now()->greaterThanOrEqualTo($publicationDate);
                                            $statusText = $isPublished ? 'public' : 'programé';
                                            $statusClass = $isPublished
                                                ? 'bg-success-subtle text-success'
                                                : 'bg-danger-subtle text-danger';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                    @elseif (($column['type'] ?? null) === 'file' && $value)
                                        @php
                                            $normalizedValue = str_replace('\\', '/', (string) $value);
                                            $isRemoteFile =
                                                str_starts_with($normalizedValue, 'http://') ||
                                                str_starts_with($normalizedValue, 'https://');
                                            $fileUrl = $isRemoteFile
                                                ? $normalizedValue
                                                : route($fileRoute, ['path' => $normalizedValue]);
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank" rel="noopener"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-download me-1"></i> Ouvrir
                                        </a>
                                    @elseif (($column['type'] ?? null) === 'date' && $value)
                                        {{ \Illuminate\Support\Carbon::parse($value)->format('d/m/Y') }}
                                    @elseif ($column['key'] === 'titre' && is_scalar($value))
                                        <strong>{{ Str::limit((string) $value, 60) }}</strong>
                                    @elseif ($column['key'] === 'designation' && is_scalar($value))
                                        {{ Str::limit((string) $value, 55) }}
                                    @else
                                        {{ is_scalar($value) ? ($value ?: '-') : '-' }}
                                    @endif
                                </td>
                            @endforeach
                            @if ($hasAnneeField)
                                <td>{{ data_get($item, 'annee.annee', '-') }}</td>
                            @endif
                            @if ($resource && $fields)
                                <td class="text-center">
                                    @if ($user->autorisation == true)
                                        <div class="resource-actions">
                                            <button type="button" class="btn btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editResource{{ $item->id }}" title="Modifier"
                                                aria-label="Modifier"><i class="fas fa-pen"></i></button>
                                            <form action="{{ route($resource . '.destroy', $item->id) }}"
                                                method="POST" onsubmit="return confirm('Supprimer cet élément ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Supprimer"
                                                    aria-label="Supprimer"><i class="fas fa-trash-can"></i></button>
                                            </form>
                                        </div>
                                    @else
                                        <i class="fa fa-lock fs-4 text-danger"></i>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 + ($hasAnneeField ? 1 : 0) + ($resource && $fields ? 1 : 0) }}"
                                class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                Aucun élément à afficher.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($resource && $fields)
    <div class="modal fade" id="createResourceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route($resource . '.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-plus me-2"></i>{{ $formTitle }}</h5><button
                            type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="resource-form-grid">
                            @foreach ($fields as $field)
                                @include('dg.partials.resource-field', [
                                    'field' => $field,
                                    'fieldOptions' => $fieldOptions,
                                    'item' => null,
                                ])
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary"><i
                                class="fas fa-floppy-disk me-1"></i>Enregistrer</button></div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($items as $item)
        <div class="modal fade" id="editResource{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <form action="{{ route($resource . '.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-pen me-2"></i>Modifier : {{ $formTitle }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="resource-form-grid">
                                @foreach ($fields as $field)
                                    @include('dg.partials.resource-field', [
                                        'field' => $field,
                                        'fieldOptions' => $fieldOptions,
                                        'item' => $item,
                                    ])
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary"><i
                                    class="fas fa-save me-1"></i>Enregistrer</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif

@push('scripts')
    <script>
        document.querySelectorAll('.resource-search').forEach(function(input) {
            input.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const table = this.closest('.card').querySelector('tbody');
                table.querySelectorAll('tr').forEach(function(row) {
                    row.hidden = !row.textContent.toLowerCase().includes(query);
                });
            });
        });
    </script>
@endpush
