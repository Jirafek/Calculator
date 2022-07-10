import React from 'react';
import CreateBuyPage from '../components/CreateBuyPage';
import { buy_data } from '../utils/buyPage_helper';
import { avability } from '../utils/days_helper';

export default function BuyPeople() {
    return <CreateBuyPage data={buy_data.add_person} avability={avability.AVAILIBLE_PEOPLE}/>
}
