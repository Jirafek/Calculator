import React, { useEffect } from 'react';
import { highterItems, monthes, color_classes, btns_name, eventSend, URL_BACKEND, clearEvent } from '../utils/days_helper';
import RandomKey from './RandomKey';

export default function ModalWindow(params) {

    function setColors() {
        const color_divs = color_classes.map(name => {
            return <div onClick={() => colorClick(name)} key={RandomKey()} className={`${name} modal-squere`}></div>
        })

        return color_divs;
    }

    function colorClick(color) {
        eventSend.color = color;
        console.log(eventSend);
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
            return <button type="submit" onClick={saveClick} key={RandomKey()} className={className}>{name}</button>
        } else {
            return <button onClick={deleteClick} key={RandomKey()} className={className}>{name}</button>
        }
    }

    function cancelClick() {
        const targetData = {
            description: '',
            title: '',
            phone: '',
            id: null
        }
        params.updateSatate(<ModalWindow targetData={targetData} day={params.day}/>, 'window', '');
    }

    async function saveClick() {
        const log = localStorage.getItem('auth');
        const session = JSON.parse(log).session;
        console.log(eventSend);

        await fetch(`${URL_BACKEND}/event/`, {
            method: "POST",
            body: JSON.stringify(eventSend),
            headers: {
                'Token': session
            }
        })
        .then(res => {
            if (res.status >= 200 && res.status < 300) {
                return res.json();
            } 
    
            throw res.json();
        }).then(res => {
            alert(res.message);
            clearEvent();
            cancelClick();
        })
    }

    async function deleteClick() {
        const id = params.targetData.id;
        if (!id) return;

        const log = localStorage.getItem('auth');
        const session = JSON.parse(log).session;

        await fetch(`${URL_BACKEND}/event/${id}`, {
            method: "DELETE",
            headers: {
                'Token': session
            }
        })
        .then(res => {
            if (res.status >= 200 && res.status < 300) {
                return res.json();
            } 
    
            throw res.json();
        }).then(res => {
            alert(res.message);
            clearEvent();
            cancelClick();
        })
    }

    function inputChangeDataTite(e) {
        const target = e.target;
        const value = target.value;
        eventSend.title = value;
    }

    function inputChangeDataPhone(e) {
        const target = e.target;
        const value = target.value;
        eventSend.phone = value;
    }

    function inputChangeDataText(e) {
        const target = e.target;
        const value = target.value;
        eventSend.description = value;
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
                    <input onChange={inputChangeDataTite}
                      defaultValue={params.targetData.title || ''} 
                      type="text" 
                      maxLength="15" 
                      placeholder="Добавить название" 
                      className="modal-head_input modal_inp"
                    />
                    <input onChange={inputChangeDataPhone} 
                      defaultValue={params.targetData.phone || ''} 
                      type="tel" 
                      className="modal-phone_inp grey modal_inp" 
                      placeholder="+7 (_ _ _) _ _ _ - _ _ - _ _"
                    />
                </div>
                <div className="modal-color_div">{setColors()}</div>
                <textarea 
                  onChange={inputChangeDataText} 
                  defaultValue={params.targetData.description || ''} 
                  className="modal-textArea grey" 
                  placeholder="Добавьте описание">
                </textarea>
                <div className="modal-btns_div">{setButtons()}</div>
            </div>
    )
}
