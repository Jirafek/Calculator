import React, { useEffect } from 'react';
import { highterItems, monthes, color_classes, btns_name } from '../utils/days_helper';
import RandomKey from './RandomKey';

export default function ModalWindow(params) {

    function setColors() {
        const color_divs = color_classes.map(name => {
            return <div key={RandomKey()} className={`${name} modal-squere`}></div>
        })

        return color_divs;
    }

    function setButtons() {
        const buttons = btns_name.map(name => {
            return setButtonClicker('grey modal_btn', name);
        })

        return buttons;
    }

    function setButtonClicker(className, name) {
        if (name === 'Отмена') {
            return <button onClick={cancelClick} key={RandomKey()} className={className}>{name}</button>
        } else if (name === 'Сохранить') {
            return <button onClick={saveClick} key={RandomKey()} className={className}>{name}</button>
        } else {
            return <button onClick={deleteClick} key={RandomKey()} className={className}>{name}</button>
        }
    }

    function cancelClick() {
        params.updateSatate(<ModalWindow day={params.day}/>, 'window', '');
    }

    function saveClick() {

    }

    function deleteClick() {

    }

    return (
            <div className="modal-wrapper">
                <div className="modal-head_div">
                    <div className="modal-name grey">
                        {highterItems[params.day].name}
                    </div>
                    <div className="modal-number grey">
                        {highterItems[params.day].number}
                    </div>
                    <div className="modal-month grey">
                        {`${monthes[highterItems[params.day].date.getMonth()]} ${highterItems[params.day].date.getFullYear()}`}
                    </div>
                    <div className="modal-time grey">{params.time || ''}</div>
                </div>
                <div className="modal-name_div">
                    <input type="text" maxLength="15" placeholder="Добавить название" className="modal-head_input modal_inp" />
                    <input type="text" className="modal-phone_inp grey modal_inp" placeholder="+7 (_ _ _) _ _ _ - _ _ - _ _" />
                </div>
                <div className="modal-color_div">{setColors()}</div>
                <textarea className="modal-textArea grey" placeholder="Добавьте описание"></textarea>
                <div className="modal-btns_div">{setButtons()}</div>
            </div>
    )
}
