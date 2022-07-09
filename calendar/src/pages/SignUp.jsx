import React, { useState } from 'react';
import { useForm } from "react-hook-form";
import { URL_BACKEND, checkSessionFunc, email_pattern } from '../utils/days_helper';
import { Navigate } from 'react-router-dom';

export default function SignUp() {
    const [state, setState] = useState({
        user: localStorage.getItem('auth')
    });
    const { register, handleSubmit, formState: { errors } } = useForm();
     
    async function onSubmit(data) {
        await fetch(`${URL_BACKEND}/authorization?type=registration`, {
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
            console.log(res);

            setState({ user: res.login });
        })
    }

    return (
        <div className="dop_wrapper">
            <div className="dop_head dop_head-logup">Регистрация</div>
            <div className="dop_body">
                {state.user && (
                    <Navigate to="/login" replace={true} />
                )}
                <form className="innerUp-main" onSubmit={handleSubmit(onSubmit)}>
                    <input type="text" className="innerUp-login innerUp-inp innerUp-main_inp" placeholder="Логин" {...register("login", { minLength: 4 })} />
                    <input type="email" className="innerUp-email innerUp-inp innerUp-main_inp" placeholder="E-mail" {...register("email", { minLength: 8 })} />
                    <input type="password" className="innerUp-password innerUp-inp innerUp-main_inp" placeholder="Пароль" {...register("password", { required: true })} />
                    <button type="submit" className="innerUp-btn">Регистрация</button>
                </form>
                <div className="inner_scinny">
                    <button className="yandex_btn inner_scinny-btn">
                        <div className="inner_scinny-img yandex_img"></div>
                    </button>
                    <button className="vk_btn inner_scinny-btn">
                        <div className="inner_scinny-img vk_img"></div>
                    </button>
                </div>
            </div>
        </div>
    )
}
