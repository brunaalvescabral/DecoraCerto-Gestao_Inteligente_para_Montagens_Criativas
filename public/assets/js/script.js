// /Função javascript para mostrar tabela de inserção de ativo sobrepondo a página home
// script para abrir e fechar algum modal, caso necessário
let mostrar= document.querySelector("<class/id>(ação/bt[abrir drop])");
let add_good = document.querySelector("<class/id(drop)>");
let botao_fechar = document.querySelector("<class/id>(ação/bt[fechar drop])")

mostrar.addEventListener('click', ()=>{
  add_good.style.visibility = 'visible';
})
botao_fechar.addEventListener('click',()=>{
  add_good.style.visibility = 'hidden';
}) 