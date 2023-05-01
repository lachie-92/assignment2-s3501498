<!DOCTYPE html>
<html>

<head>
    <title>Main Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="header">
        <a href="/">
            <div class="logo">Music Streaming</div>
        </a>
        <div>
            <button onclick="location.href='/logout.php'">Logout</button>

        </div>

    </div>
    <div class="container">
        <h2>User Area</h2>
        <p><?php echo $user['user_name']['S'] ?></p>
        <!-- Add user area content here -->
    </div>
    <div class="container">
        <h2>Subscribed Music</h2>
        <?php if (empty($musicRecords)) { ?>
            <p>No music has been subscribed to yet! Subscribe to some below</p>
        <?php } else { ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Year</th>
                        <th>Unsubscribe</th>
                    </tr>
                </thead>
                <tbody id="subscribed-music">
                    <?php foreach ($musicRecords as $music) { ?>
                        <tr>
                            <td><img src="<?php echo $music['img_url']; ?>" alt="<?php echo $music['artist']; ?>" width="50"></td>
                            <td><?php echo $music['title']; ?></td>
                            <td><?php echo $music['artist']; ?></td>
                            <td><?php echo $music['year']; ?></td>
                            <td><button class="unsubscribe-btn" onclick="location.href='/unsubscribe?id=<?php echo $music['id']; ?>'" data-id="<?php echo $music['id']; ?>">Remove</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <div class="container">
        <h2>Query Music</h2>
        <div class="form-group">
            <label for="title">Title:</label>
            <textarea id="title" name="title"></textarea>
        </div>
        <div class="form-group">
            <label for="year">Year:</label>
            <textarea id="year" name="year"></textarea>
        </div>
        <div class="form-group">
            <label for="artist">Artist:</label>
            <textarea id="artist" name="artist"></textarea>
        </div>
        <button id="query-btn" type="button">Query</button>
        <hr>
        <div class="results">
            <h2>Query Result</h2>
            <div id="grid-container" style="width: 100%; display: grid;
    grid-template-columns: auto auto auto;
    padding: 10px;"></div>
        </div>
    </div>


    <script src="js/app.js"></script>

</body>

</html>