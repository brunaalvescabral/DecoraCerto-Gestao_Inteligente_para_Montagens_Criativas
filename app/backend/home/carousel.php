<?php
function getAllCards(){
    $allCards = [
        [
            'id' => 1,
            'name' => 'Carta Vintage Azul',
            'description' => 'Uma bela carta vintage com padrões azuis clássicos e detalhes dourados.',
            'image' => '',
            'category' => 'Vintage',
            'collection' => 'Coleção Clássica'
        ],
        [
            'id' => 2,
            'name' => 'Carta Vintage Vermelha',
            'description' => 'Carta vintage com padrões vermelhos vibrantes e acabamento premium.',
            'image' => '',
            'category' => 'Vintage',
            'collection' => 'Coleção Clássica'
        ],
        [
            'id' => 3,
            'name' => 'Carta Vintage Verde',
            'description' => 'Carta vintage com padrões verdes elegantes e detalhes em prata.',
            'image' => '',
            'category' => 'Vintage',
            'collection' => 'Coleção Clássica'
        ],
        [
            'id' => 4,
            'name' => 'Carta Vintage Dourada',
            'description' => 'Carta premium com acabamento dourado e detalhes ornamentados.',
            'image' => '',
            'category' => 'Premium',
            'collection' => 'Coleção Exclusiva'
        ],
        [
            'id' => 5,
            'name' => 'Carta Vintage Roxa',
            'description' => 'Carta vintage com padrões roxos misteriosos e detalhes em ouro.',
            'image' => '',
            'category' => 'Vintage',
            'collection' => 'Coleção Mística'
        ],
        [
            'id' => 6,
            'name' => 'Carta Vintage Laranja',
            'description' => 'Carta vintage com padrões laranja vibrantes e detalhes em bronze.',
            'image' => '',
            'category' => 'Vintage',
            'collection' => 'Coleção Vibrante'
        ],
        [
            'id' => 7,
            'name' => 'Carta Vintage Rosa',
            'description' => 'Delicada carta vintage com tons rosados e acabamento perolado.',
            'image' => '',
            'category' => 'Deluxe',
            'collection' => 'Coleção Romântica'
        ],
        [
            'id' => 8,
            'name' => 'Carta Vintage Turquesa',
            'description' => 'Carta exótica com padrões turquesa e detalhes em prata envelhecida.',
            'image' => '',
            'category' => 'Exótica',
            'collection' => 'Coleção Oceânica'
        ],
        [
            'id' => 9,
            'name' => 'Carta Vintage Marrom',
            'description' => 'Carta rústica com tons terrosos e acabamento em couro envelhecido.',
            'image' => '',
            'category' => 'Rústica',
            'collection' => 'Coleção Terra'
        ],
        [
            'id' => 10,
            'name' => 'Carta Vintage Cinza',
            'description' => 'Elegante carta vintage em tons de cinza com detalhes metálicos.',
            'image' => '',
            'category' => 'Elegante',
            'collection' => 'Coleção Metálica'
        ],
        [
            'id' => 11,
            'name' => 'Carta Vintage Prata',
            'description' => 'Sofisticada carta com acabamento prateado e padrões Art Déco.',
            'image' => '',
            'category' => 'Art Déco',
            'collection' => 'Coleção Sofisticada'
        ],
        [
            'id' => 12,
            'name' => 'Carta Vintage Coral',
            'description' => 'Vibrante carta com tons coral e detalhes em madrepérola.',
            'image' => '',
            'category' => 'Tropical',
            'collection' => 'Coleção Marina'
        ],
        [
            'id' => 13,
            'name' => 'Carta Vintage Índigo',
            'description' => 'Misteriosa carta com tons índigo profundos e padrões celestiais.',
            'image' => '',
            'category' => 'Celestial',
            'collection' => 'Coleção Cósmica'
        ],
        [
            'id' => 14,
            'name' => 'Carta Vintage Âmbar',
            'description' => 'Rara carta com tons âmbar translúcidos e inclusions douradas.',
            'image' => '',
            'category' => 'Rara',
            'collection' => 'Coleção Preciosa'
        ]
    ];
    $imagens = AddCardImages();
    $contem = [];
    foreach ($allCards as $i => $card) {
        if (empty($imagens)) {
            $allCards[$i]['image'] = "https://picsum.photos/300/400?random=" . $card['id'];
            continue;
        }
        do {
            $r = rand(0, count($imagens) - 1);
        } while (in_array($r, $contem) && $contem);
        $contem[] = $r;
        $allCards[$i]['image'] = "./arquivos/imagens/kits/usuariotal/" . $imagens[$r];
    }
    return $allCards;
}
function getCardById($id){
    $cards = getAllCards();
    foreach ($cards as $card) {
        if ($card['id'] == $id) {
            return $card;
        }
    }
    return null;
}
function AddCardImages() {
    $diretorio = "./arquivos/imagens/kits/usuariotal";
    $ignore = ['.', '..', "zroot"];
    $imagens = [];
    if (is_dir($diretorio)) {
        $itens = scandir($diretorio);
        foreach ($itens as $imagem) {
            if (is_file($diretorio .'/' . $imagem) && !in_array($imagem, $ignore)) {
                $imagens[] = $imagem;
            }
        }

        return $imagens;
    }
    return [];
}
function RenomearImagens(){
    $diretorio = "./arquivos/imagens/kits/usuariotal";
    $ignore = ['.', '..', "zroot"];
    $imagens = [];
    if (is_dir($diretorio)) {
        $itens = scandir($diretorio);
        $contador = 1;
        foreach ($itens as $imagem) {
            $caminhoAntigo = $diretorio .'/'. $imagem;
            if (is_file($caminhoAntigo) && !in_array($imagem, $ignore)) {
                // pega extensão do arquivo (.jpg, .png, etc)
                $extensao = pathinfo($imagem, PATHINFO_EXTENSION);
                // novo nome (exemplo: img1.jpg, img2.png...)
                $novoNome = "kit" . $contador . "." . $extensao;
                $caminhoNovo = $diretorio . '/' . $novoNome;
                // renomeia o arquivo
                if (rename($caminhoAntigo, $caminhoNovo)) {
                    $imagens[] = $novoNome;
                } else {
                    $imagens[] = $imagem; // fallback se falhar
                }
                $contador++;
            }
        }
        return $imagens;
    }
    return [];
}
function getRelatedCards($cardId, $limit = 12){
    $variations = [
        "Clássico",
        "Escuro",
        "Claro",
        "Brilhante",
        "Pastel",
        "Metálico",
        "Vintage",
        "Neon",
        "Fosco",
        "Perolado",
        "Cristal",
        "Premium"
    ];
    $relatedCards = [];
    for ($i = 0; $i < $limit; $i++) {
        $relatedCards[] = [
            'name' => 'Carta ' . $variations[$i],
            'image' => "https://picsum.photos/300/400?random={$cardId}" . ($i + 20),
            'collection' => 'Coleção Relacionada'
        ];
    }
    return $relatedCards;
}