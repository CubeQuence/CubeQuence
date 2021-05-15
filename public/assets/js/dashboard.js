alert('welcome to dashboard');

document.addEventListener('DOMContentLoaded', function () {
    M.Sidenav.init(
        document.querySelectorAll('.sidenav'),
        {
            edge: 'right'
        }
    );
});
