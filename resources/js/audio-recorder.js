const MAX_DURATION_SECONDS = 120;

function initRecorder(root) {
    const recordBtn = root.querySelector('[data-record-btn]');
    const status = root.querySelector('[data-status]');
    const preview = root.querySelector('[data-preview]');
    const resetBtn = root.querySelector('[data-reset]');
    const fileInput = root.parentElement.querySelector('[data-audio-input]');
    const durationInput = root.parentElement.querySelector('[data-audio-duration]');

    if (!navigator.mediaDevices || typeof MediaRecorder === 'undefined') {
        status.textContent = "Enregistrement vocal non pris en charge par ce navigateur.";
        recordBtn.disabled = true;
        return;
    }

    let mediaRecorder = null;
    let chunks = [];
    let startedAt = null;
    let timerId = null;
    let stream = null;

    function pickMimeType() {
        const candidates = ['audio/webm;codecs=opus', 'audio/webm', 'audio/ogg', 'audio/mp4'];
        return candidates.find((type) => MediaRecorder.isTypeSupported(type)) || '';
    }

    function stopStream() {
        if (stream) {
            stream.getTracks().forEach((track) => track.stop());
            stream = null;
        }
    }

    function updateTimer() {
        const elapsed = Math.floor((Date.now() - startedAt) / 1000);
        status.textContent = `Enregistrement… ${elapsed}s / ${MAX_DURATION_SECONDS}s`;
        if (elapsed >= MAX_DURATION_SECONDS) {
            stopRecording();
        }
    }

    function startRecording() {
        navigator.mediaDevices.getUserMedia({ audio: true }).then((mediaStream) => {
            stream = mediaStream;
            chunks = [];
            const mimeType = pickMimeType();
            mediaRecorder = mimeType ? new MediaRecorder(stream, { mimeType }) : new MediaRecorder(stream);

            mediaRecorder.addEventListener('dataavailable', (e) => {
                if (e.data.size > 0) chunks.push(e.data);
            });

            mediaRecorder.addEventListener('stop', () => {
                const blob = new Blob(chunks, { type: mediaRecorder.mimeType || 'audio/webm' });
                const durationSeconds = Math.round((Date.now() - startedAt) / 1000);
                const file = new File([blob], `message-vocal.${blob.type.includes('ogg') ? 'ogg' : 'webm'}`, { type: blob.type });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                durationInput.value = durationSeconds;

                preview.src = URL.createObjectURL(blob);
                preview.style.display = 'block';
                resetBtn.style.display = 'inline';
                status.textContent = `Message vocal enregistré (${durationSeconds}s)`;
                recordBtn.classList.remove('recording');
                stopStream();
            });

            mediaRecorder.start();
            startedAt = Date.now();
            recordBtn.classList.add('recording');
            recordBtn.setAttribute('aria-label', "Arrêter l'enregistrement");
            timerId = setInterval(updateTimer, 1000);
            updateTimer();
        }).catch(() => {
            status.textContent = "Impossible d'accéder au micro. Vérifiez les autorisations du navigateur.";
        });
    }

    function stopRecording() {
        if (timerId) {
            clearInterval(timerId);
            timerId = null;
        }
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
        }
    }

    recordBtn.addEventListener('click', () => {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            stopRecording();
        } else {
            startRecording();
        }
    });

    resetBtn.addEventListener('click', () => {
        fileInput.value = '';
        durationInput.value = '';
        preview.removeAttribute('src');
        preview.style.display = 'none';
        resetBtn.style.display = 'none';
        status.textContent = "Décrivez votre projet à l'oral (2 min max)";
    });
}

document.querySelectorAll('[data-audio-recorder]').forEach(initRecorder);
