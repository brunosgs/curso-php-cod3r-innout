<aside class="sidebar">
    <nav class="menu mt-3">
        <ul class="nav-list">
            <?php if ($user->is_admin) : ?>
            <li class="nav-item">
                <a href="UsersController.php">
                    <i class="icofont-users mr-2">
                        <span class="ml-2">Usuários</span>
                    </i>
                </a>
            </li>
            <?php endif ?>
            <li class="nav-item">
                <a href="DayRecordsController.php">
                    <i class="icofont-ui-check">
                        <span class="ml-2">Registrar Ponto</span>
                    </i>
                </a>
            </li>
            <li class="nav-item">
                <a href="MonthlyReportController.php">
                    <i class="icofont-ui-calendar">
                        <span class="ml-2">Relatório Mensal</span>
                    </i>
                </a>
            </li>
            <?php if ($user->is_admin) : ?>
            <li class="nav-item">
                <a href="ManagerReportController.php">
                    <i class="icofont-chart-histogram">
                        <span class="ml-2">Relatório Gerencial</span>
                    </i>
                </a>
            </li>
            <?php endif ?>
        </ul>
    </nav>
    <div class="sidebar-widgets">
        <div class="sidebar-widget">
            <i class="icon icofont-hour-glass text-primary"></i>
            <div class="info">
                <span class="main text-primary"
                    <?= $activeClock === 'workedInterval' ? 'active-clock' : '' ?>><?= $workedInterval ?></span>
                <span class="label text-muted">Horas trabalhadas</span>
            </div>
        </div>
        <div class="division my-3"></div>
        <div class="sidebar-widget">
            <i class="icon icofont-ui-alarm text-danger"></i>
            <div class="info">
                <span class="main text-danger"
                    <?= $activeClock === 'exitTime' ? 'active-clock' : '' ?>><?= $exitTime ?></span>
                <span class="label text-muted">Hora de saída</span>
            </div>
        </div>
    </div>
</aside>