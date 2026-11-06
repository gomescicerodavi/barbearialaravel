<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b100d">
    <meta name="description" content="Conheça a trajetória de Neymar Jr. e descubra quanto você sabe sobre o craque no quiz.">
    <title>Neymar Jr. — Joga bonito. Faz história.</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="site-header">
        <a class="brand" href="#inicio" aria-label="Neymar Jr., início">
            <span class="brand-mark">N</span>
            <span>NEYMAR<span class="brand-dot">.</span></span>
        </a>
        <nav class="main-nav" aria-label="Navegação principal">
            <a href="#historia">História</a>
            <a href="#conquistas">Conquistas</a>
            <a href="#quiz">Quiz</a>
            <a href="#ranking">Ranking</a>
        </nav>
        @auth
            <div class="account-menu">
                <span>OLÁ, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">SAIR ↗</button>
                </form>
            </div>
        @else
            <a class="header-cta" href="#quiz">Entrar e jogar <span aria-hidden="true">↗</span></a>
        @endauth
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">
            <span></span><span></span>
        </button>
    </header>

    <main>
        <section class="hero" id="inicio">
            <div class="hero-grid" aria-hidden="true"></div>
            <div class="hero-content">
                <p class="eyebrow"><span class="live-dot"></span> A história de um camisa 10</p>
                <h1>Joga bonito.<br><span>Faz história.</span></h1>
                <p class="hero-copy">Do futebol de rua à glória mundial. Uma jornada feita de ousadia, talento e momentos que ficam para sempre.</p>
                <div class="hero-actions">
                    <a class="button button-lime" href="#historia">Explorar trajetória <span aria-hidden="true">↓</span></a>
                    <a class="text-link" href="#quiz"><span class="play-icon" aria-hidden="true">▶</span> Você conhece essa história?</a>
                </div>
                <div class="hero-caption"><span class="caption-line"></span> UM LEGADO EM MOVIMENTO</div>
            </div>
            <div class="hero-art" aria-label="Ilustração gráfica da camisa 10">
                <div class="orbit orbit-one"></div>
                <div class="orbit orbit-two"></div>
                <div class="hero-stamp">NEY<br><span>JR.</span></div>
                <div class="hero-number">10</div>
                <div class="hero-ball" aria-hidden="true"><span></span></div>
                <div class="art-label"><span>OUSADIA</span><span>·</span><span>BRASIL</span><span>·</span><span>FUTEBOL</span></div>
                <div class="art-year">2009 — ∞</div>
            </div>
            <a class="scroll-cue" href="#historia"><span></span> ROLE PARA DESCOBRIR</a>
        </section>

        <section class="intro-strip" aria-label="Destaques da carreira">
            <div class="strip-label">UMA CARREIRA<br>SEM FRONTEIRAS</div>
            <div class="strip-item"><strong>03</strong><span>continentes<br>conquistados</span></div>
            <div class="strip-item"><strong>06</strong><span>capítulos<br>inesquecíveis</span></div>
            <div class="strip-item"><strong>01</strong><span>paixão: jogar<br>com alegria</span></div>
            <div class="strip-arrow" aria-hidden="true">↗</div>
        </section>

        <section class="section journey-section" id="historia">
            <div class="section-heading">
                <div>
                    <p class="eyebrow"><span class="eyebrow-number">01 /</span> A JORNADA</p>
                    <h2>Do Brasil<br>para o <span>mundo.</span></h2>
                </div>
                <p class="section-note">Cada camisa, um novo capítulo.<br>O talento sempre foi o mesmo.</p>
            </div>
            <div class="timeline">
                <article class="timeline-card timeline-santos">
                    <div class="timeline-top"><span class="timeline-year">2009 — 2013</span><span class="timeline-index">01</span></div>
                    <div class="club-symbol santos-symbol">S</div>
                    <div class="timeline-info">
                        <span class="timeline-kicker">ONDE TUDO COMEÇOU</span>
                        <h3>Menino<br>da Vila</h3>
                        <p>Santos FC · Brasil</p>
                        <span class="timeline-detail">A Vila Belmiro viu nascer um fenômeno. Dribles, ousadia e uma Libertadores que marcou época.</span>
                    </div>
                    <span class="card-arrow" aria-hidden="true">↗</span>
                </article>
                <article class="timeline-card timeline-barca">
                    <div class="timeline-top"><span class="timeline-year">2013 — 2017</span><span class="timeline-index">02</span></div>
                    <div class="club-symbol barca-symbol">FCB</div>
                    <div class="timeline-info">
                        <span class="timeline-kicker">O MUNDO AOS SEUS PÉS</span>
                        <h3>Conquista<br>da Europa</h3>
                        <p>FC Barcelona · Espanha</p>
                        <span class="timeline-detail">Ao lado de Messi e Suárez, formou um dos ataques mais eletrizantes do futebol. A Champions veio em 2015.</span>
                    </div>
                    <span class="card-arrow" aria-hidden="true">↗</span>
                </article>
                <article class="timeline-card timeline-psg">
                    <div class="timeline-top"><span class="timeline-year">2017 — 2023</span><span class="timeline-index">03</span></div>
                    <div class="club-symbol psg-symbol">P</div>
                    <div class="timeline-info">
                        <span class="timeline-kicker">UM NOVO DESAFIO</span>
                        <h3>O capítulo<br>em Paris</h3>
                        <p>Paris Saint-Germain · França</p>
                        <span class="timeline-detail">Novos palcos, grandes jogadas e títulos nacionais em uma das fases mais intensas da carreira.</span>
                    </div>
                    <span class="card-arrow" aria-hidden="true">↗</span>
                </article>
                <article class="timeline-card timeline-brazil">
                    <div class="timeline-top"><span class="timeline-year">2010 — HOJE</span><span class="timeline-index">04</span></div>
                    <div class="club-symbol brazil-symbol">BR</div>
                    <div class="timeline-info">
                        <span class="timeline-kicker">A CAMISA AMARELA</span>
                        <h3>Orgulho<br>do Brasil</h3>
                        <p>Seleção Brasileira</p>
                        <span class="timeline-detail">Ouro olímpico no Rio 2016, Copa das Confederações e uma história construída com a Amarelinha.</span>
                    </div>
                    <span class="card-arrow" aria-hidden="true">↗</span>
                </article>
                <article class="timeline-card timeline-alhilal">
                    <div class="timeline-top"><span class="timeline-year">2023 — 2025</span><span class="timeline-index">05</span></div>
                    <div class="club-symbol hilal-symbol">H</div>
                    <div class="timeline-info">
                        <span class="timeline-kicker">NOVOS HORIZONTES</span>
                        <h3>Um capítulo<br>na Arábia</h3>
                        <p>Al-Hilal · Arábia Saudita</p>
                        <span class="timeline-detail">Uma nova cultura, novos desafios e mais um capítulo internacional na trajetória do camisa 10.</span>
                    </div>
                    <span class="card-arrow" aria-hidden="true">↗</span>
                </article>
                <article class="timeline-card timeline-return">
                    <div class="timeline-top"><span class="timeline-year">2025 — HOJE</span><span class="timeline-index">06</span></div>
                    <div class="club-symbol return-symbol">S</div>
                    <div class="timeline-info">
                        <span class="timeline-kicker">DE VOLTA ÀS ORIGENS</span>
                        <h3>O retorno<br>à Vila</h3>
                        <p>Santos FC · Brasil</p>
                        <span class="timeline-detail">A história voltou para casa. Uma nova página escrita onde tudo começou.</span>
                    </div>
                    <span class="card-arrow" aria-hidden="true">↗</span>
                </article>
            </div>
        </section>

        <section class="honors-section" id="conquistas">
            <div class="honors-inner">
                <div class="section-heading honors-heading">
                    <div>
                        <p class="eyebrow"><span class="eyebrow-number">02 /</span> A GALERIA</p>
                        <h2>Feitos que<br><span>viraram história.</span></h2>
                    </div>
                    <p class="section-note">Mais do que troféus.<br>Memórias para sempre.</p>
                </div>
                <div class="honors-grid">
                    <article class="honor-card honor-featured">
                        <span class="honor-icon" aria-hidden="true">✳</span>
                        <span class="honor-year">2011</span>
                        <h3>Copa Libertadores</h3>
                        <p>O continente voltou a ser do Peixe.</p>
                        <span class="honor-tag">SANTOS FC</span>
                    </article>
                    <article class="honor-card">
                        <span class="honor-icon" aria-hidden="true">✦</span>
                        <span class="honor-year">2015</span>
                        <h3>UEFA Champions League</h3>
                        <p>A maior noite do futebol europeu.</p>
                        <span class="honor-tag">FC BARCELONA</span>
                    </article>
                    <article class="honor-card">
                        <span class="honor-icon" aria-hidden="true">◈</span>
                        <span class="honor-year">2016</span>
                        <h3>Ouro Olímpico</h3>
                        <p>Um sonho brasileiro no Maracanã.</p>
                        <span class="honor-tag">SELEÇÃO BRASILEIRA</span>
                    </article>
                    <article class="honor-card">
                        <span class="honor-icon" aria-hidden="true">★</span>
                        <span class="honor-year">2011</span>
                        <h3>Prêmio Puskás</h3>
                        <p>Um gol que o mundo não esqueceu.</p>
                        <span class="honor-tag">GOL DO ANO · FIFA</span>
                    </article>
                </div>
                <div class="honors-foot"><span>O LEGADO CONTINUA</span><span class="foot-rule"></span><span>NEYMAR JR. <b>10</b></span></div>
            </div>
        </section>

        <section class="quiz-section section" id="quiz">
            <div class="quiz-decoration" aria-hidden="true">10</div>
            <div class="quiz-copy">
                <p class="eyebrow"><span class="eyebrow-number">03 /</span> AGORA É COM VOCÊ</p>
                <h2>Você sabe<br>tudo sobre o <span>Menino Ney?</span></h2>
                <p>5 perguntas. 15 segundos cada. Entre ou crie sua conta, escolha seu nível e dispute uma posição no ranking.</p>
                <div class="quiz-perks">
                    <span><b>01</b> Escolha a dificuldade</span>
                    <span><b>02</b> Responda contra o relógio</span>
                    <span><b>03</b> Guarde seu melhor resultado</span>
                </div>
            </div>
            <div class="quiz-panel" data-start-url="{{ route('quiz.start') }}" data-answer-url="{{ route('quiz.answer') }}" data-score-url="{{ route('quiz.score') }}" data-csrf="{{ csrf_token() }}" data-current-user="{{ auth()->id() }}">
                <div class="quiz-panel-head"><span class="panel-label"><span class="live-dot"></span> DESAFIO NEYMAR</span><span class="panel-count">01 — 05</span></div>
                <div class="quiz-stage" aria-live="polite">
                    @auth
                        <div class="quiz-welcome">
                            <div class="quiz-ball" aria-hidden="true">✳</div>
                            <h3>Hora do desafio, {{ auth()->user()->name }}.</h3>
                            <p>Seu resultado vai direto para o ranking. Qual é o seu nível?</p>
                            @if (session('status'))
                                <p class="auth-status">{{ session('status') }}</p>
                            @endif
                            <div class="difficulty-options">
                                <button class="difficulty-button" type="button" data-difficulty="facil"><span class="difficulty-dot easy"></span><span><b>De boa</b><small>Fácil</small></span><span class="difficulty-arrow">↗</span></button>
                                <button class="difficulty-button" type="button" data-difficulty="medio"><span class="difficulty-dot medium"></span><span><b>Na medida</b><small>Médio</small></span><span class="difficulty-arrow">↗</span></button>
                                <button class="difficulty-button" type="button" data-difficulty="dificil"><span class="difficulty-dot hard"></span><span><b>Craque mesmo</b><small>Difícil</small></span><span class="difficulty-arrow">↗</span></button>
                            </div>
                        </div>
                    @else
                        <div class="auth-welcome">
                            <div class="auth-tabs" role="tablist" aria-label="Acesso à conta">
                                <button class="auth-tab {{ $errors->register->any() ? '' : 'is-active' }}" id="login-tab" type="button" role="tab" aria-selected="{{ $errors->register->any() ? 'false' : 'true' }}" aria-controls="login-form">Entrar</button>
                                <button class="auth-tab {{ $errors->register->any() ? 'is-active' : '' }}" id="register-tab" type="button" role="tab" aria-selected="{{ $errors->register->any() ? 'true' : 'false' }}" aria-controls="register-form">Criar conta</button>
                            </div>
                            <form class="auth-form" id="login-form" method="POST" action="{{ route('login') }}" role="tabpanel" aria-labelledby="login-tab" @if ($errors->register->any()) hidden @endif>
                                @csrf
                                <h3>Entre para jogar.</h3>
                                <p>Seu melhor resultado fica salvo no ranking.</p>
                                <label for="login-email">E-mail</label>
                                <input id="login-email" type="email" name="email" autocomplete="email" value="{{ old('email') }}" maxlength="254" required>
                                @error('email', 'login')<span class="auth-error">{{ $message }}</span>@enderror
                                <label for="login-password">Senha</label>
                                <input id="login-password" type="password" name="password" autocomplete="current-password" required>
                                @error('password', 'login')<span class="auth-error">{{ $message }}</span>@enderror
                                <label class="remember-label"><input type="checkbox" name="remember" value="1"> Manter conectado</label>
                                <button class="auth-submit" type="submit">Entrar e escolher dificuldade <span>↗</span></button>
                            </form>
                            <form class="auth-form" id="register-form" method="POST" action="{{ route('register') }}" role="tabpanel" aria-labelledby="register-tab" @if (!$errors->register->any()) hidden @endif>
                                @csrf
                                <h3>Crie sua conta.</h3>
                                <p>Um perfil para guardar sua melhor pontuação.</p>
                                <label for="register-name">Nome no ranking</label>
                                <input id="register-name" type="text" name="name" autocomplete="name" value="{{ old('name') }}" minlength="2" maxlength="25" required>
                                @error('name', 'register')<span class="auth-error">{{ $message }}</span>@enderror
                                <label for="register-email">E-mail</label>
                                <input id="register-email" type="email" name="email" autocomplete="email" value="{{ old('email') }}" maxlength="254" required>
                                @error('email', 'register')<span class="auth-error">{{ $message }}</span>@enderror
                                <label for="register-password">Senha (mínimo 8 caracteres)</label>
                                <input id="register-password" type="password" name="password" autocomplete="new-password" minlength="8" required>
                                @error('password', 'register')<span class="auth-error">{{ $message }}</span>@enderror
                                <label for="register-password-confirmation">Confirme a senha</label>
                                <input id="register-password-confirmation" type="password" name="password_confirmation" autocomplete="new-password" minlength="8" required>
                                <button class="auth-submit" type="submit">Criar conta e jogar <span>↗</span></button>
                            </form>
                            @if (session('status'))
                                <p class="auth-status">{{ session('status') }}</p>
                            @endif
                        </div>
                    @endauth
                </div>
                <div class="quiz-panel-foot"><span>SEM PRESSÃO. SÓ FUTEBOL.</span><span>✦</span></div>
            </div>
        </section>

        <section class="leaderboard-section section" id="ranking">
            <div class="leaderboard-intro">
                <p class="eyebrow"><span class="eyebrow-number">04 /</span> QUEM SABE, SABE</p>
                <h2>Hall da<br><span>fama.</span></h2>
                <p>Os maiores conhecedores da trajetória do camisa 10 estão aqui.</p>
                <a class="text-link" href="#quiz">Quero entrar no ranking <span aria-hidden="true">↗</span></a>
            </div>
            <div class="leaderboard-card">
                <div class="leaderboard-head"><span>RANKING</span><span>PONTOS</span></div>
                <div class="leaderboard-rows" id="leaderboard-rows">
                    @forelse ($leaders as $index => $leader)
                        <div class="leader-row" data-user-id="{{ $leader->user_id }}">
                            <span class="leader-place {{ $index < 3 ? 'top-place' : '' }}">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="leader-avatar">{{ mb_strtoupper(mb_substr($leader->name, 0, 1)) }}</span>
                            <span class="leader-name">{{ $leader->name }}<small>{{ ucfirst($leader->difficulty) }} · {{ $leader->correct_answers }}/5 acertos</small></span>
                            <strong class="leader-score">{{ number_format($leader->score, 0, ',', '.') }}<small>PTS</small></strong>
                        </div>
                    @empty
                        <div class="leader-empty"><span aria-hidden="true">✳</span><p>O primeiro lugar está esperando por você.</p><a href="#quiz">Jogar o quiz ↗</a></div>
                    @endforelse
                </div>
                <div class="leaderboard-foot"><span>ATUALIZADO A CADA JOGADA</span><span>NEYMAR JR. <b>10</b></span></div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <a class="brand footer-brand" href="#inicio"><span class="brand-mark">N</span><span>NEYMAR<span class="brand-dot">.</span></span></a>
        <span>UMA HOMENAGEM A QUEM JOGA COM ALEGRIA.</span>
        <a href="#inicio">VOLTAR AO TOPO ↑</a>
    </footer>
</body>
</html>
