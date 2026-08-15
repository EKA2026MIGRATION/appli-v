// document.getElementById('mainContent').webkitRequestFullscreen();
const screen = document.getElementById('mainContent');

const booklet = new BookletChild(bookletChildData);

let navigation = new Navigation(screen, navElements, templates, booklet);

navigation.startShow();


const goToBoard = (boardId) => {
    navigation.showPage(boardId);
}