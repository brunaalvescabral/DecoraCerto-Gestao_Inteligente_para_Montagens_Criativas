<!-- ===== PAINEL DE FUNCIONALIDADES COM DESIGN QUE QUERO ===== -->
<section class="container-fluid mx-auto px-4 sm:px-6 lg:px-8 py-1 md:py-12">
    <section class="funcionalidades" id="funcionalidade">
        <h3 class="titulo">Toda a gestão da sua empresa em um único lugar.</h3>
        <div class="cartao">
            <div class="logo-container">
                <img class="logo_animada" src="<?= include_asset('imagens/image-logo.png') ?>" alt="Logo GIMC" style="width:100%; margin-top: 30px">
            </div>
            <!-- BOTÃO PRINCIPAL PARA MOSTRAR FUNCIONALIDADES -->
            <div class="plataforma">
                <button id="btn-funcionalidades" class="btn-plataforma">FUNCIONALIDADES</button>
                <ul id="botoes-funcionais" class="plataformas">
                    <li>
                        <button class="btn-plataforma btn-funcionalidades-expansiva  btn-controle" >CONTROLE</button>
                        <div id="controle" class="conteudo">
                            📦 Gestão de estoque<br />
                            😊 Gestão dos clientes e fornecedores<br />
                            🚚 Gestão da entrega e devolução dos produtos (logística)<br />
                            💰 Controle das parcelas dos pagamentos dos contratos<br />
                            ✔️ Contas a pagar<br />
                            ❌ Contas a receber<br />
                            📊 Relatórios gerenciais<br />
                            🔐 Permissão de acesso dos usuários<br />
                            💲 Controle de comissão dos atendentes e vendedores
                        </div>
                    </li>
                    <li>
                        <!-- SEÇÃO PRODUTIVIDADE -->
                        <button class="btn-plataforma btn-funcionalidades-expansiva btn-produtividade">PRODUTIVIDADE</button>
                        <div id="produtividade" class="conteudo">
                            📱 Aplicativo completo e integrado ao sistema<br />
                            🗓️ Consulta de disponibilidade do estoque por período<br />
                            📝 Emissão online de Orçamentos e Contratos de locação<br />
                            📤 Envio de orçamentos e contratos por e-mail e whatsapp<br />
                            📧 Envio de recibos por e-mail<br />
                            📆 Visualização de agenda<br />
                            ✍️ Impressão de contrato com assinatura digital<br />
                            📅 Calendário de feriados<br />
                            📈 Gráficos de fácil interpretação<br />
                            💻 Backups automático<br />
                            ✔️ Sistema multi-usuário
                        </div>
                    </li>
                    <li>
                        <!-- SEÇÃO SITE INTEGRADO -->
                        <button class="btn-plataforma btn-funcionalidades-expansiva btn-site">SITE INTEGRADO</button>
                        <div id="site" class="conteudo">
                            🛒 Loja virtual<br />
                            🧾 Catálogo virtual de produtos<br />
                            🚩 Área de produtos em destaque<br />
                            👍 Solicitação de orçamentos pelo cliente<br />
                            🧠 Configuração da aparência do site<br />
                            📸 Disponibilização de banners promocionais<br />
                            💲 Integração com o PagSeguro<br />
                            💬 Formulário de contato<br />
                            📄 Criação de páginas dinâmicas
                        </div>
                    </li>
                </ul>
            </div>
    </section>
</section>