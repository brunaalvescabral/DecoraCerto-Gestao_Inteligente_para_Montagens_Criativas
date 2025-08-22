import { carregarDados } from "../scripts_auxiliares/request.js";

function ElementosCarousel() {
    const carouselById = document.getElementById('carousel');
    const prevBtnById = document.getElementById('prevBtn');
    const nextBtnById = document.getElementById('nextBtn');
    const cardsByClass = document.querySelectorAll('.cardCarousel');
    return {
        carouselById,
        prevBtnById,
        nextBtnById,
        cardsByClass
    };
}

export default function initializarCarousel() {
    const { carouselById: carousel, prevBtnById: prevBtn, nextBtnById: nextBtn, cardsByClass: cardCarousel } = ElementosCarousel();
    const velocidadeScroll = 1000;
    if (!carousel || !prevBtn || !nextBtn) {
        console.error('❌ Elementos ausentes para inicialização');
        return;
    }
    if (cardCarousel.length > 0) {
        cardCarousel.forEach(card => {
            manipularCard(card);
        });
    }
    prevBtn.addEventListener('click', function () {
        carousel.scrollBy({
            left: -velocidadeScroll,
            behavior: 'smooth'
        });
    });
    nextBtn.addEventListener('click', function () {
        carousel.scrollBy({
            left: velocidadeScroll,
            behavior: 'smooth'
        });
    });
}
function manipularCard(card = null) {
    if (card != null) {
        card.addEventListener("click", () => {
            let number = card.id;
            let match = number.match(/\d+/);
            let cardId = match ? parseInt(match[0], 10) : -1;
            carregarDados('card', cardId).then(card => {
                manipularModalImagePrevias(card[0]);
            }).catch(error => {
                console.error('Erro ao buscar os dados do card:', error);
            });
        });
    }
}
function manipularModalImagePrevias(card = null) {
    if (card != null) {
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalCardName = document.getElementById('modalCardName');
        const modalCardDescription = document.getElementById('modalCardDescription');

        modalImage.src = card.image;
        modalTitle.textContent = card.collection;
        modalCardName.textContent = card.name;
        modalCardDescription.textContent = card.description;
        openModal('imageModal');
    }
}

export function openModal(modalID) {
    const modal = document.getElementById(modalID);
    const closeModal_BT = document.querySelector(`#${modalID} .modalClose_BT`);
    const todosModais = document.querySelectorAll('.modal');
    todosModais.forEach(modalForClose => {
        closeModal(modalForClose.id);
    });
    modal.classList.remove('hidden'); 
    modal.style.zIndex = '1000';
    document.body.style.overflow = 'hidden';
    modal.style.overflow = "";
    closeModal_BT.addEventListener('click', () => closeModal(modalID), { once: true });
}
export function closeModal(modalID) {
    const modal = document.getElementById(modalID);
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}


