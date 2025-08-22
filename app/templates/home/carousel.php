    <?= include_backEnd("home", "carousel"); ?>
    <!-- Carousel Section -->
    <section class="container-fluid mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="relative mb-12">
            <!-- Carousel Container with Navigation Buttons -->
            <div class="relative">
                <!-- Left Navigation Button -->
                <button id="prevBtn" class="carousel-btn carousel-nav-left">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <!-- Carousel -->
                <div id="carousel" class="carousel-container flex space-x-4 md:space-x-6 overflow-x-auto py-4 px-16" style="scroll-snap-type: x mandatory;">
                    <?php foreach (getAllCards() as $i => $card): ?>
                        <div id="card<?= $i?>" style="scroll-snap-align: center;animation-delay: <?= ($i * 0.1) ?>s;" class="cardCarousel card-enter flex-shrink-0 w-48 sm:w-56 md:w-64 bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer">
                            <div class="p-2">
                                <img <?= "src={$card['image']} alt={$card['name']}" ?> class="w-full h-48 sm:h-56 md:h-64 object-cover rounded-lg">
                            </div>
                            <div class="p-4">
                                <h3 class="text-base md:text-lg font-semibold text-gray-800"><?= $card["name"] ?></h3>
                                <p class="text-xs md:text-sm text-gray-600 mt-1"> <?= $card["collection"] ?></p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-purple-100 to-blue-100 text-purple-800">
                                        <?= $card['category'] ?>
                                    </span>
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <!-- Cards will be generated here -->
                </div>

                <!-- Right Navigation Button -->
                <button id="nextBtn" class="carousel-btn carousel-nav-right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

