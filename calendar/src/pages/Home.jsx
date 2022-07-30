import React, { useState } from 'react';
import Header from '../components/Header';
import HihterMenu from '../components/HihterMenu';
import LowerMenu from '../components/LowerMenu';
import { URL_BACKEND, dates, days } from '../utils/days_helper';
import { Navigate } from 'react-router-dom';

export default function Home() {
    const [pageState, setPageState] = useState(null);

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

    function nextPage() {
        const date = dates.lastDate;
        setPageState(date)
    }

    function prevPage() {
        const date = dates.firstDate;
        date.setDate(date.getDate() - 8);
        setPageState(date)
    }

    return (
        <>
        {!localStorage.getItem('auth') && (
            <Navigate to="/login" replace={true} />
        )}
            <Header updateState={updateState} updatePageState={setPageState} />
            <div className="wrapper">
                <div className="arrows">
                    <i onClick={prevPage} className="arrow_left"></i>
                    <i onClick={nextPage} className="arrow_right"></i>
                </div>
                <div className={`modal_window ${state.winClass}`}>{state.window}</div>
                <div className={`modal_calendar ${state.calClass}`}>{state.calendar}</div>
                <HihterMenu date={pageState} updateState={updateState} />
                <LowerMenu updateState={updateState} />
            </div>
        </>
    )
}
