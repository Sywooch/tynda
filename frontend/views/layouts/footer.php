<!--=== Footer Version 1 ===-->
<div class="footer-v1">
    <div class="footer">
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-md-3 md-margin-bottom-40">
                    <div class="headline"><h2>НАША ТЫНДА</h2></div>
                    <p>Городской портал Наша Тында,<br> создан специально для Вас.</p>
                </div><!--/col-md-3-->
                <!-- End About -->

                <!-- Latest -->
                <div class="col-md-3 md-margin-bottom-40">
                    <div class="posts">
                        <div class="headline"><h2>Новости</h2></div>
                        <ul class="list-unstyled latest-list">
                            <li>
                                <a href="#">Incredible content</a>
                                <small>May 8, 2014</small>
                            </li>
                            <li>
                                <a href="#">Best shoots</a>
                                <small>June 23, 2014</small>
                            </li>
                            <li>
                                <a href="#">New Terms and Conditions</a>
                                <small>September 15, 2014</small>
                            </li>
                        </ul>
                    </div>
                </div><!--/col-md-3-->
                <!-- End Latest -->

                <!-- Link List -->
                <div class="col-md-3 md-margin-bottom-40">
                    <div class="headline"><h2>Полезные ссылки</h2></div>
                    <ul class="list-unstyled link-list">
                        <li><a href="#">О портале</a><i class="fa fa-angle-right"></i></li>
                        <li><a href="#">Как пользоваться</a><i class="fa fa-angle-right"></i></li>
                        <li><a href="#">Часто задаваемые вопросы</a><i class="fa fa-angle-right"></i></li>
                        <li><a href="#">Обратная связь</a><i class="fa fa-angle-right"></i></li>
                        <li><a href="#">Сотрудничество и реклама</a><i class="fa fa-angle-right"></i></li>
                    </ul>
                </div><!--/col-md-3-->
                <!-- End Link List -->

                <!-- Address -->
                <div class="col-md-3 map-img md-margin-bottom-40">
                    <div class="headline"><h2>Контакты</h2></div>
                    <address class="md-margin-bottom-40">
                        Россия, Амурская область <br />
                        г. Тында <br />
                        тел: 800 123 3456 <br />
                        тел: 800 123 3456 <br />
                        Email: <a href="mailto:info@nashatynda.ru" class="">info@nashatynda.ru</a>
                    </address>
                </div><!--/col-md-3-->
                <!-- End Address -->
            </div>
        </div>
    </div><!--/footer-->

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <p>
                        2015 - <?= date('Y') ?> &copy;  Наша Тында. Все права защищены.
                        <a href="#">Политика использования</a> | <a href="#">Правила и соглашения</a>
                        <?php
                        $user = \Yii::$app->user->identity;
                            if($user->username == 'denoll'){
                                echo number_format(memory_get_usage()/1024/1024,3,',',' ').' | '. number_format(memory_get_peak_usage()/1024/1024,3,',',' ');
                            }
                        ?>
                    </p>
                </div>

                <!-- Social Links -->
                <div class="col-md-2">
                    <p>Создано:&nbsp;<a href="http://denoll.ru" target="_blank">denoll</a></p>
                </div>
                <!-- End Social Links -->
            </div>
        </div>
    </div><!--/copyright-->
</div>
<!--=== End Footer Version 1 ===-->

