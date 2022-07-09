import { keyData } from '../utils/days_helper';

function getKey(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

export default function RandomKey() {
    const KEY_NUMBER = 10;
    let wrd = '';
    for (let i=0; i<KEY_NUMBER; i++) {
        wrd += keyData[getKey(0, keyData.length - 1)];
    }
    return wrd
}
