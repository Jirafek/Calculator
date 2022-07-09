import React, { useState } from 'react';
import { useForm } from "react-hook-form";
import { URL_BACKEND, checkSessionFunc } from '../utils/days_helper';
import { Navigate } from 'react-router-dom';
import { Link } from 'react-router-dom';

localStorage.clear('auth')

export default function Profile() {
    const { register, handleSubmit, formState: { errors } } = useForm();

    async function onSubmit(data) {

        console.log(JSON.stringify(data))

        await fetch(`${URL_BACKEND}/user?type=personal_data`, {
            method: 'PATCH',
            body: JSON.stringify(data)
        })
        .then(res => {
            if (res.status >= 200 && res.status < 300) {
                return res.json();
            } 
    
            throw res.json();
        })
        .catch(res => {
            console.log('session canceled')
            alert(res.message);
        })
        .then(res => {
            alert(res.message);
        })
    }

    return (
        <div className="dop_wrapper">
            <div className="dop_head">Профиль</div>
            <div className="dop_body-lg">
                <div className="profile-head">
                    <div className="profile-photo">
                        <div className="profile-photo_item"></div>
                    </div>
                    <input type="text" className="profile-nick" placeholder="Никнейм" />
                </div>
                <form style={{ display: 'flex', flexDirection: 'column' }} onSubmit={handleSubmit(onSubmit)}>
                    <div className="profile-main">
                        <input type="text" className="profil-login" placeholder="Логин" {...register("login", { minLength: 4 })} />
                        <input type="email" className="profil-email" placeholder="E-mail" {...register("email", { required: false })} />
                        <input type="number" className="profil-phone" placeholder="7 (_ _ _) _ _ _ - _ _ - _ _" {...register("telephone", { required: false })} />
                        <input type="password" className="profil-pass" placeholder="Пароль" {...register("password", { minLength: 8 })} />
                    </div>
                    <div className="profil-footer">
                        <button className="profil_footBtn">Добавить пользователя</button>
                        <input type="text" className="profil_footInp" placeholder="Название группы" />
                        <button className="profil_footBtn-list">Посмотреть список вашей группы</button>
                    </div>
                    <div className="profil_buttons">
                        <button className="profil_btn profil_delete">Удалить профиль</button>
                        <Link to="/"><button className="profil_btn profil_cancel">Отмена</button></Link>
                        <button type="submit" className="profil_btn profil_save">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    )
}
