<div class="container mt-5">
    <h3>Statistic</h3>

    <?php if (isset($error)) : ?>

        <h3><?= $error ?></h3>

    <?php else: ?>

        <div class="row ">
            <?php foreach ($statistic as $customerId => $userStatistic) : ?>
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <p class="card-text">CustomerId: <?= $customerId ?></p>
                                <p class="card-text">Number of all customer calls: <?= $userStatistic['number_of_calls'] ?></p>
                                <p class="card-text">Total duration of all calls: <?= $userStatistic['total_duration'] ?></p>
                            </div>

                            <?php if (isset($userStatistic['continents'])): ?>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Continent</th>
                                        <th scope="col">Number of customer calls</th>
                                        <th scope="col">Duration of customer calls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($userStatistic['continents'] as $continent => $continentStatistic) : ?>

                                        <tr>
                                            <td><?= $continent ?></td>
                                            <td><?= $continentStatistic['continents_count'] ?></td>
                                            <td><?= $continentStatistic['total_continents_count'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>

                                </table>

                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <a href="/">
        <button class="btn btn-danger">Home</button>
    </a>
</div>

