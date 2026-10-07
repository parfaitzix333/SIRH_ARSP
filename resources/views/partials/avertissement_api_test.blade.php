<div class="alert alert-warning alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
    <span class="fs-4 me-2">⚠️</span>
    <div>
        <strong>Mode test</strong><br>
        L'API de reconnaissance faciale est actuellement en mode test.
        Les résultats peuvent être temporaires ou indisponibles.
    </div>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>


<div id="apiTestAlert"></div>

<script>
    document.getElementById("apiTestAlert").innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
            <span class="fs-4 me-2">⚠️</span>
            <div>
                <strong>Mode test</strong><br>
                L'API de reconnaissance faciale est actuellement en mode test.
            </div>
            <button type="button" class="btn-close ms-auto"
                    data-bs-dismiss="alert"
                    aria-label="Fermer"></button>
        </div>
    `;
</script>
