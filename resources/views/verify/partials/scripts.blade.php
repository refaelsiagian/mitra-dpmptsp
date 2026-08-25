    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;
            
            const btnNext = document.getElementById('btn-next');
            const btnPrev = document.getElementById('btn-prev');
            const btnSubmit = document.getElementById('btn-submit');
            const progressLine = document.getElementById('progress-line');
            const spacer = document.getElementById('spacer');

            @include('verify.scripts.ui')
            @include('verify.scripts.validation')
            @include('verify.scripts.logic')
            @include('verify.scripts.region')
            @include('verify.scripts.kbli')
            @include('verify.scripts.map')
        });
    </script>
