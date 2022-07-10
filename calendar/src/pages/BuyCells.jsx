import React from 'react';
import CreateBuyPage from '../components/CreateBuyPage';
import { buy_data } from '../utils/buyPage_helper';
import { avability } from '../utils/days_helper';

export default function BuyCells() {
    return <CreateBuyPage data={buy_data.add_cell} avability={avability.AVAILIBLE_LINES}/>
}
