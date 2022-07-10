import React from 'react';
import { buy_btns } from '../utils/buyPage_helper';
import RandomKey from './RandomKey';
import { useNavigate } from "react-router-dom";

export default function CreateBuyPage(props) {
    let navigate = useNavigate();

    function cancelClick() {
        navigate(-1)
    }

    function createBodyBtn() {
        const newArray = buy_btns.map((el, i) => {
            return (
                <div key={RandomKey()} className="menu_btn">
                    <div style={{ color: buy_btns[i].color }} className="menu_btn-number">
                        {`+${buy_btns[i].number}`}
                    </div>
                    <div style={{ color: buy_btns[i].color }} className="menu_btn-average">
                        {`${buy_btns[i].average}`}
                    </div>
                </div>
            );
        })

        return (
            <>
                <div className="buy_menu-first">{newArray.slice(0, 2)}</div>
                <div className="buy_menu-second">{newArray.slice(2, 4)}</div>
            </>
        )
    }

    function createFooterBtn() {
        const newArray = buy_btns.map((el, i) => {
            return (
                <button key={RandomKey()} style={{ color: buy_btns[i].color }} className="footer_btns-item">
                    {`+${buy_btns[i].number}`}
                </button>
            );
        })

        const centerButton = 
        <button key={RandomKey()} style={{ color: '#FD79A8' }} className="footer_btns-item">
            {props.avability}
        </button>

        newArray.splice(2, 0, centerButton)

        return newArray;
    }

    return (
        <div className="dop_wrapper">
            <div className={`dop_head ${props.data.title.className}`}>
                {props.data.title.text}
            </div>
            <div className="dop_body buy_menu">
                <p className={props.data.header.className}>
                    {props.data.header.text}
                </p>
                <p className={props.data.main.className}>
                    {props.data.main.text}
                </p>
                <div className="buy_menu-btns">
                    {createBodyBtn()}
                    <button onClick={cancelClick} className="menu-btns_cancel">Отмена</button>
                </div>
            </div>
            <div className="dop_footer">
                <p className={props.data.footer.className}>
                    {props.data.footer.text}
                </p>
                <div className="footer_btns">
                    {createFooterBtn()}
                </div>
            </div>
        </div>
    )
}
