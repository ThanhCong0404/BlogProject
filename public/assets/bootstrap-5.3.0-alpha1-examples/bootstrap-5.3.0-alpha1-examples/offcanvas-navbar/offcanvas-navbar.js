(() => {
  'use strict'

  document.addEventListener('click', (event) => {
    if (event.target.id === 'navbarSideCollapse') {
      document.querySelector('.offcanvas-collapse').classList.toggle('open')
    }
  })
})()


(() => {
  'use strict'

  document.addEventListener('click', (event) => {
    if (event.target.matches('#navbarSideCollapse')) {
      document.querySelector('.offcanvas-collapse').classList.toggle('open')
    }
  })
})()
