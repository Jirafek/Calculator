import React, { useState } from 'react';
import Header from '../components/Header';
import HihterMenu from '../components/HihterMenu';
import LowerMenu from '../components/LowerMenu';

export default function Home() {
    const [state, setState] = useState({
        window: null,
        calendar: null,
        winClass: '',
        calClass: ''
    });

    function updateState(params, name, className) {
        if (name === 'window') {
            setState(state => {
                return {
                    ...state,
                    window: params,
                    calendar: null,
                    winClass: className,
                    calClass: null
                }
            })
        } else {
            setState(state => {
                return {
                    ...state,
                    window: null,
                    calendar: params,
                    calClass: className,
                    winClass: null
                }
            })
        }
    }

    return (
        <>
            <Header updateState={updateState} />
            <div className="wrapper">
                <div className="arrows">
                    <i className="arrow_left"></i>
                    <i className="arrow_right"></i>
                </div>
                <div className={`modal_window ${state.winClass}`}>{state.window}</div>
                <div className={`modal_calendar ${state.calClass}`}>{state.calendar}</div>
                <HihterMenu updateState={updateState} />
                <LowerMenu updateState={updateState} />
            </div>
        </>
    )
}
