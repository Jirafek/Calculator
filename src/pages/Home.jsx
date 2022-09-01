import { useState } from 'react';
import { Link } from 'react-router-dom';
import { months, daysWeek } from '../util/vars.js';

export default function Home() {
    const [today] = useState(new Date());

    return (
        <>
            <header className="header header-home">
                <div className="header-home__conntainer container ">
                    <div className="header-home__date-today date-today">
                        <div className="date-today__month">
                            {months[today.getMonth()]}
                        </div>
                        <div className="date-today__day-year">
                            <div className="date-today__day">
                                {today.getDate()}  {daysWeek[today.getDay()]}
                            </div>
                            <div className="date-today__line"></div>
                            <div className="date-today__year">
                                {today.getFullYear()}
                            </div>
                        </div>
                    </div>
                    <div className="header-home__select-date">
                        <svg width="4rem" height="4rem" viewBox="0 0 63 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26.0592 46.7799H51.9592C53.3837 46.7799 54.5492 45.6145 54.5492 44.19C54.5492 42.7654 53.3837 41.6 51.9592 41.6H26.0592C24.6347 41.6 23.4692 42.7654 23.4692 44.19C23.4692 45.6145 24.6347 46.7799 26.0592 46.7799ZM7.9292 18.29C7.9292 19.7145 9.0947 20.88 10.5192 20.88H51.9592C53.3837 20.88 54.5492 19.7145 54.5492 18.29C54.5492 16.8655 53.3837 15.7 51.9592 15.7H10.5192C9.0947 15.7 7.9292 16.8655 7.9292 18.29ZM26.0592 33.83H51.9592C53.3837 33.83 54.5492 32.6644 54.5492 31.24C54.5492 29.8155 53.3837 28.65 51.9592 28.65H26.0592C24.6347 28.65 23.4692 29.8155 23.4692 31.24C23.4692 32.6644 24.6347 33.83 26.0592 33.83Z" fill="#2D3436" />
                        </svg>
                    </div>
                    <Link to="/" className="header-home__to-profile"></Link>
                </div>
            </header>
            <main className="main main-home">
                <div className="main-home__top">
                    
                </div>
                <div className="main-home__bottom">

                </div>
                {/* 3231212312123 */}
            </main>
        </>
    )
}