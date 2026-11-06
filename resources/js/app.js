import './bootstrap';

const menuButton = document.querySelector('.menu-toggle');
const navigation = document.querySelector('.main-nav');

menuButton?.addEventListener('click', () => {
    const expanded = menuButton.getAttribute('aria-expanded') === 'true';
    menuButton.setAttribute('aria-expanded', String(!expanded));
    menuButton.setAttribute('aria-label', expanded ? 'Abrir menu' : 'Fechar menu');
    navigation?.classList.toggle('is-open', !expanded);
});

navigation?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
        menuButton?.setAttribute('aria-expanded', 'false');
        menuButton?.setAttribute('aria-label', 'Abrir menu');
        navigation.classList.remove('is-open');
    });
});

document.querySelectorAll('.auth-tab').forEach((tab) => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.auth-tab').forEach((item) => {
            const isActive = item === tab;
            item.classList.toggle('is-active', isActive);
            item.setAttribute('aria-selected', String(isActive));
        });
        document.querySelectorAll('.auth-form').forEach((form) => {
            form.hidden = form.id !== tab.getAttribute('aria-controls');
        });
    });
});

const panel = document.querySelector('.quiz-panel');
const stage = panel?.querySelector('.quiz-stage');
const panelCount = panel?.querySelector('.panel-count');
const leaderboardRows = document.querySelector('#leaderboard-rows');
let timerInterval;
let currentQuestion;
let result;
let isAnswering = false;

const element = (tag, className, text) => {
    const node = document.createElement(tag);
    if (className) node.className = className;
    if (text !== undefined) node.textContent = text;
    return node;
};

async function postJson(url, payload) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': panel.dataset.csrf,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(payload),
    });

    const data = await response.json();
    if (!response.ok) {
        throw new Error(data.message || 'Não foi possível concluir a solicitação. Tente novamente.');
    }

    return data;
}

function showError(container, message) {
    const existing = container.querySelector('.js-error');
    if (existing) existing.remove();
    container.append(element('p', 'js-error', message));
}

function setBusy(isBusy) {
    panel.querySelectorAll('.difficulty-button').forEach((button) => {
        button.disabled = isBusy;
    });
}

async function startQuiz(difficulty) {
    setBusy(true);
    try {
        const data = await postJson(panel.dataset.startUrl, { difficulty });
        showQuestion(data.question);
    } catch (error) {
        setBusy(false);
        showError(stage, error.message);
    }
}

function showQuestion(question) {
    clearInterval(timerInterval);
    currentQuestion = question;
    isAnswering = false;
    panelCount.textContent = `${String(question.index + 1).padStart(2, '0')} — ${String(question.total).padStart(2, '0')}`;

    const view = element('div', 'question-view');
    const meta = element('div', 'question-meta');
    const difficultyNames = { facil: 'FÁCIL', medio: 'MÉDIO', dificil: 'DIFÍCIL' };
    meta.append(
        element('span', '', `${difficultyNames[question.difficulty]} · PERGUNTA ${question.index + 1}`),
        element('span', 'timer', `${question.seconds}s`),
    );
    const track = element('div', 'timer-track');
    const progress = element('div', 'timer-progress');
    track.append(progress);
    view.append(meta, track, element('h3', '', question.question));

    const answers = element('div', 'answers');
    const feedback = element('p', 'answer-feedback', '');
    question.choices.forEach((choice, index) => {
        const button = element('button', 'answer-button');
        button.type = 'button';
        button.dataset.option = String(index);
        button.append(element('span', 'answer-key', String.fromCharCode(65 + index)), element('span', '', choice));
        button.addEventListener('click', () => submitAnswer(index, button, answers, feedback));
        answers.append(button);
    });
    view.append(answers, feedback);
    stage.replaceChildren(view);
    startTimer(question.seconds, meta.querySelector('.timer'), progress, answers, feedback);
}

function startTimer(seconds, timer, progress, answers, feedback) {
    const startedAt = Date.now();
    const update = () => {
        const remaining = Math.max(0, seconds - Math.floor((Date.now() - startedAt) / 1000));
        timer.textContent = `${remaining}s`;
        progress.style.width = `${(remaining / seconds) * 100}%`;
        if (remaining <= 5) {
            timer.classList.add('is-low');
            progress.classList.add('is-low');
        }
        if (remaining === 0) {
            clearInterval(timerInterval);
            submitAnswer(null, null, answers, feedback);
        }
    };

    update();
    timerInterval = window.setInterval(update, 200);
}

async function submitAnswer(option, selectedButton, answers, feedback) {
    if (isAnswering) return;
    isAnswering = true;
    clearInterval(timerInterval);
    answers.querySelectorAll('.answer-button').forEach((button) => {
        button.disabled = true;
    });

    try {
        const data = await postJson(panel.dataset.answerUrl, {
            index: currentQuestion.index,
            option,
        });
        answers.querySelectorAll('.answer-button').forEach((button) => {
            if (button.textContent.slice(1).trim() === data.correct_choice) button.classList.add('correct');
        });
        if (!data.correct && selectedButton) selectedButton.classList.add('wrong');
        feedback.textContent = data.correct
            ? `Boa! +${data.points} pontos. ${data.explanation}`
            : `${option === null ? 'Tempo esgotado!' : 'Quase!'} ${data.correct_choice}. ${data.explanation}`;
        if (!data.correct) feedback.classList.add('is-wrong');
        window.setTimeout(() => {
            if (data.complete) {
                showResult(data.result);
            } else {
                showQuestion(data.question);
            }
        }, 1250);
    } catch (error) {
        isAnswering = false;
        answers.querySelectorAll('.answer-button').forEach((button) => {
            button.disabled = false;
        });
        showError(stage, error.message);
    }
}

function shareText() {
    return `Acertei ${result.correct}/${result.total} no quiz do Neymar Jr. e fiz ${result.score} pontos! Será que você consegue?`;
}

function createShareActions() {
    const actions = element('div', 'share-actions');
    const whatsapp = element('a', 'share-button', 'WhatsApp ↗');
    whatsapp.href = `https://wa.me/?text=${encodeURIComponent(shareText())}`;
    whatsapp.target = '_blank';
    whatsapp.rel = 'noopener noreferrer';
    const x = element('a', 'share-button', 'X ↗');
    x.href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText())}`;
    x.target = '_blank';
    x.rel = 'noopener noreferrer';
    const instagram = element('button', 'share-button', 'Instagram / copiar');
    instagram.type = 'button';
    instagram.addEventListener('click', async () => {
        try {
            if (navigator.share) {
                await navigator.share({ text: shareText(), title: 'Meu resultado no Quiz Neymar Jr.' });
            } else {
                await navigator.clipboard.writeText(shareText());
                instagram.textContent = 'Copiado!';
            }
        } catch (error) {
            if (error.name !== 'AbortError') showError(actions, 'Não foi possível compartilhar agora.');
        }
    });
    actions.append(whatsapp, x, instagram);
    return actions;
}

function showResult(finalResult) {
    clearInterval(timerInterval);
    result = finalResult;
    panelCount.textContent = 'FIM DE JOGO';
    const view = element('div', 'result-view');
    view.append(
        element('div', 'quiz-ball', '✳'),
        element('h3', '', 'Apito final!'),
        element('p', 'result-score', `${result.score} PTS`),
        element('p', 'result-copy', `${result.correct} de ${result.total} respostas certas · ${result.difficulty}`),
    );
    const saveButton = element('button', 'auth-submit', 'Salvar minha melhor pontuação no ranking ↗');
    saveButton.type = 'button';
    saveButton.addEventListener('click', () => saveScore(saveButton));
    view.append(saveButton, createShareActions());
    stage.replaceChildren(view);
}

async function saveScore(button) {
    button.disabled = true;
    try {
        const data = await postJson(panel.dataset.scoreUrl, {});
        button.remove();
        stage.querySelector('.result-view').append(element('p', 'result-saved', data.message));
        addLeaderboardEntry(data.entry);
    } catch (error) {
        button.disabled = false;
        showError(stage, error.message);
    }
}

function addLeaderboardEntry(entry) {
    const existing = [...leaderboardRows.querySelectorAll('.leader-row')].map((row) => ({
        user_id: Number(row.dataset.userId),
        name: row.querySelector('.leader-name').childNodes[0].textContent.trim(),
        score: Number(row.querySelector('.leader-score').childNodes[0].textContent.replace(/\D/g, '')),
        difficulty: row.querySelector('.leader-name small').textContent.split(' · ')[0].toLowerCase(),
        correct_answers: Number(row.querySelector('.leader-name small').textContent.match(/(\d+)\/5/)?.[1] || 0),
    }));
    const updatedRanking = existing.filter((leader) => leader.user_id !== entry.user_id);
    updatedRanking.push(entry);
    updatedRanking.sort((a, b) => b.score - a.score);
    leaderboardRows.replaceChildren();
    updatedRanking.slice(0, 5).forEach((leader, index) => {
        const row = element('div', 'leader-row');
        row.dataset.userId = leader.user_id;
        const place = element('span', `leader-place ${index < 3 ? 'top-place' : ''}`, String(index + 1).padStart(2, '0'));
        const avatar = element('span', 'leader-avatar', leader.name.slice(0, 1).toUpperCase());
        const name = element('span', 'leader-name', leader.name);
        name.append(element('small', '', `${leader.difficulty} · ${leader.correct_answers}/5 acertos`));
        const score = element('strong', 'leader-score', leader.score.toLocaleString('pt-BR'));
        score.append(element('small', '', 'PTS'));
        row.append(place, avatar, name, score);
        leaderboardRows.append(row);
    });
}

panel?.querySelectorAll('.difficulty-button').forEach((button) => {
    button.addEventListener('click', () => startQuiz(button.dataset.difficulty));
});
