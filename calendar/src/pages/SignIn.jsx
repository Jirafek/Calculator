import React, { useState } from 'react';
import { useForm } from "react-hook-form";
import { URL_BACKEND, checkSessionFunc, checkPage } from '../utils/days_helper';
import { Navigate } from 'react-router-dom';
import { Link } from 'react-router-dom';

export default function SignIn() {
    const [state, setState] = useState({
        user: localStorage.getItem('auth')
    });
    const { register, handleSubmit, formState: { errors } } = useForm();
     
    async function onSubmit(data) {
        await fetch(`${URL_BACKEND}/authorization?type=log`, {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(res => {
            if (res.status >= 200 && res.status < 300) {
                return res.json();
            } 
    
            throw res.json();
        })
        .catch(res => {
            alert(res.message);
        })
        .then(res => {
            alert(res.message);
    
            const authorization = {
                login: res.login,
                session: res.session
            };
    
            localStorage.setItem('auth', JSON.stringify(authorization));

            checkPage()

            setState({ user: res.login });
        })
    }

    return (
        <div className="dop_wrapper">
            <div className="dop_head">Вход</div>
            <div className="dop_body">
                {state.user && (
                    <Navigate to="/" replace={true} />
                )}
                <form style={{ display: 'flex', flexDirection: 'column' }} onSubmit={handleSubmit(onSubmit)}>
                    <input className="innerIn-login innerIn-input" type="text" placeholder="Логин" {...register("login", { minLength: 4 })} />
                    <input type="password" className="innerIn-pass innerIn-input" placeholder="Пароль" {...register("password", { minLength: 8 })} />
                    <div className="innerIn-btns">
                        <button type="submit" className="innerIn-btn">Вход</button>
                        <Link className="innerLink" to="/registration"><button className="innerIn-btn">Регистрация</button></Link>
                    </div>
                </form>
                <div className="inner_scinny">
                    <button className="yandex_btn inner_scinny-btn">
                        { <div className="inner_scinny-img yandex_img"></div> }Авторизация через Яндекс
                    </button>
                    <button className="vk_btn inner_scinny-btn">
                        { <div className="inner_scinny-img vk_img"></div> }Авторизация через ВКонтакте
                    </button>
                </div>
            </div>
        </div>
    )
}
