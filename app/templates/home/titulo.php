<div id="titulo_principal" class="text-center py-3 bg-gradient-to-r from-purple-600 via-teal-500 to-green-400 relative overflow-hidden rounded-2xl shadow-2xl mb-12">
    <!-- Efeito de luz diagonal -->
    <div class="diagonal-light"></div>
    <!-- Sparkles decorativos -->
    <?php for ($i = 0; $i < 10; $i++): ?>
        <div class="sparkle"
            style="
                top: <?= rand(1, 100) ?>%;
                left: <?= rand(1, 100) ?>%;
                animation-delay:<?= rand(0, 3) ?>s;">
        </div>
    <?php endfor; ?>
    <!-- 
    <div class="sparkle"></div>
    <div class="sparkle"></div>
    <div class="sparkle"></div>
    <div class="sparkle"></div>
    <div class="sparkle"></div>
    <div class="sparkle"></div> 
    -->
    <!-- Conteúdo principal -->
    <div class="relative z-10">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
            DecoraCerto
        </h1>
        <p class="text-lg md:text-xl text-white mt-2 opacity-90 max-w-2xl mx-auto px-4">
            Gestão Inteligente para Montagens Criativas
        </p>
    </div>
    <div class="absolute inset-0 bg-black bg-opacity-10 pointer-events-none"></div>
    <!-- <script>
        setTimeout(() => {
            for (let i = 0; i < 10; i++) {
                document.getElementById("titulo_principal").innerHTML += `
                    <div class="sparkle" style="
                    top: ${Math.random()*100}%;
                    left: ${Math.random()*100}%;
                    animation-delay: ${Math.floor(Math.random() * 6)}s;">
                    </div>`;
            }
        }, 100);
    </script> -->
</div>