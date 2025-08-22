<!-- Carousel Section -->
<div class="relative mb-12">
    <!-- <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6">Coleções em Destaque</h2> -->
    <!-- Carousel Container with Navigation Buttons -->
    <div class="relative">
        <!-- Left Navigation Button -->
        <button id="prevBtn" class="carousel-arrow carousel-nav-left absolute top-1/2 -translate-y-1/2">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <!-- Carousel -->
        <div id="carousel" class="carousel-container flex space-x-4 md:space-x-6 overflow-x-auto py-4 px-16" style="scroll-snap-type: x mandatory;">
            <!-- Cards will be generated here -->
        </div>
        <!-- Right Navigation Button -->
        <button id="nextBtn" class="carousel-arrow carousel-nav-right absolute top-1/2 -translate-y-1/2">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
</div>