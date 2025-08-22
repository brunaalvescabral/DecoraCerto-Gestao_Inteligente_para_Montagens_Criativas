<!-- Image Detail Modal -->
<div id="imageModal" class="modal hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div id="modal" class="bg-white rounded-lg max-w-6xl w-full max-h-[90vh]">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-800">Detalhes da Carta</h3>
            <button id="closeModal" class="modalClose_BT text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-times h-6 w-6"></i>
            </button>
        </div>
        <div class="p-4 md:p-6 overflow-y-auto">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 flex justify-center">
                    <img id="modalImage" src="" alt="Carta em destaque" class="rounded-lg shadow-md max-h-64 md:max-h-96 object-contain">
                </div>
                <div class="md:w-1/2 md:pl-6 mt-6 md:mt-0">
                    <h4 id="modalCardName" class="text-lg font-semibold text-gray-800 mb-2"></h4>
                    <p id="modalCardDescription" class="text-gray-600 mb-4"></p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded">Colecionável</span>
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Edição Limitada</span>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Vintage</span>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Cartas Relacionadas</h4>
                <div id="relatedCards" class="previews-container grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <?php foreach (getAllCards() as $i => $card):if($i<15):?>
                            <div class=" logar_BT preview-image cursor-pointer bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="p-2">
                                    <img src="<?=$card['image']?>"" alt="<?=$card['name']?>" class="w-full h-32 object-cover rounded">
                                </div>
                                <div class="p-2">
                                    <p class="text-xs font-medium text-gray-800"><?=$card['name']?>"</p>
                                    <p class="text-xs text-gray-500">Coleção</p>
                                </div>
                            </div>
                    <?php endif; endforeach; ?>
                    <!-- Related previews will be generated here -->
                </div>
            </div>
        </div>
    </div>
</div>