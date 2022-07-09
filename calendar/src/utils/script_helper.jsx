const buy_data = {
    add_person: {
        title: 'Добавить пользователя:person_title-text',
        header: 'Максимальное количество участников в группе  ограничено!:person_header-text',
        main: 'Желаете увеличить количество участников?:person_main-text',
        footer: 'Колличество доступных пользователей:person_footer-text'
    },
    add_cell: {
        title: 'Добавить Дополнительные ячейки:cell_title-text',
        header: 'количество бесплатных ячеек 4:cell_header-text',
        main: 'Желаете увеличить количество ячеек?:cell_main-text',
        footer: 'Колличество доступных ячеек:cell_footer-text'
    }
}

const buy_btns = [
    {
        color: '#FAB1A0',
        average: '100 руб.',
        number: 1
    },
    {
        color: '#A29BFE',
        average: '200 руб.',
        number: 3
    },
    {
        color: '#74B9FF',
        average: '300 руб.',
        number: 5
    },
    {
        color: '#027555',
        average: '500 руб.',
        number: 10
    },
];

export {buy_data, buy_btns};
