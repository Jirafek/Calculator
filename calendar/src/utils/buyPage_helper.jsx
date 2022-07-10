const buy_data = {
    add_person: {
        title: {
            text: 'Добавить пользователя',
            className: 'person_title-text'
        },
        header: {
            text: 'Максимальное количество участников в группе  ограничено!',
            className: 'person_header-text'
        },
        main: {
            text: 'Желаете увеличить количество участников?',
            className: 'person_main-text'
        },
        footer: {
            text: 'Колличество доступных пользователей',
            className: 'person_footer-text'
        }
    },
    add_cell: {
        title: {
            text: 'Добавить Дополнительные ячейки',
            className: 'cell_title-text'
        },
        header: {
            text: 'Количество бесплатных ячеек 4',
            className: 'cell_header-text'
        },
        main: {
            text: 'Желаете увеличить количество ячеек?',
            className: 'cell_main-text'
        },
        footer: {
            text: 'Колличество доступных ячеек',
            className: 'cell_footer-text'
        }
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