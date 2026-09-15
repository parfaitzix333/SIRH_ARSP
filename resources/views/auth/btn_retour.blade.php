<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    #backButton {
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1000 !important;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        padding: 0;
    }
</style>
<a class="btn btn-primary btn-sm" id="backButton" href="{{ url('/') }}" aria-label="Retour à l'accueil">
    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
</a>
