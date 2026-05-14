import { generateMorseAudio } from 'morse-audio';

async function playMorse(text) {
    try {
        const { dataUri } = await generateMorseAudio({
            text: text,
            wpm: 20
        });

        const audio = new Audio(dataUri);
        audio.play();
    } catch (error) {
        console.error('Ошибка при воспроизведении:', error);
    }
}