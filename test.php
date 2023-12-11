<style>
    .txt-hide {
        display: none;
    }

    button.more {
        margin: 30px auto;
        display: block;
        background-color: #666;
        color: #000;
        padding: 4px 0 4px 42px;
        border: none;
        outline: 0;
        background: url(../../img/common/icon14.png) no-repeat left center;
        background-size: 23px auto;
        font-weight: 700;
        font-size: 1.4rem;
        letter-spacing: 0.2em;
        text-decoration: none;
        font-family: "Noto Sans JP", sans-serif;
        transition: 0.5s;
        -erbkit-transition: 0.5s;
    }

    button.more.on-click {
        background: url(../../img/common/icon15.png) no-repeat left center;
        background-size: 23px auto;
    }

    button.more::after {
        content: "もっと見る";
        transition: 0.2s;
        -erbkit-transition: 0.2s;
    }

    button.more.on-click::after {
        content: "もとに戻す";
    }
</style>
<?php
if ($args['表示状態'] !== '非表示') {
    ?>
    <section class="com-founction">
        <div class="content">
            <h3 class="head-line03"><?php echo $args['タイトル']; ?></h3>
            <ul class="foun-list flex">
                <?php
                $posts = $args['機能'];
                foreach ($posts as $key => $post) {
                    $image_url = $post['画像'];
                    $text = $post['紹介文'];
                    ?>
                    <li class="<?php if ($key > 9) {
                        echo "txt-hide" ?><?php } ?>">
                        <!--<a href="">-->
                        <span class="pho">
                          <img src="<?php echo $image_url; ?>" alt="<?php echo $args['タイトル']; ?>"
                               class="object-fit-img">
                        </span>
                        <span id="<?= $key ?>" class="top"><?php echo nl2br($text); ?></span>
                        <!--</a>-->
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php if (count($args['機能']) > 10) { ?>
                <p>
                    <button class="more"></button>
                </p>
            <?php } ?>
        </div>
    </section>
    <?php
}
