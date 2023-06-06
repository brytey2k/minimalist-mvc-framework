<nav class="col-md-12">
    <ul class="menu clearfix">
        <?php if(check24UserIsLoggedIn()): ?>
            <li><a href="/blog/create">New Entry</a></li>
            <li><a href="/logout">Logout</a></li>
        <?php else: ?>
            <li><a href="/auth">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
