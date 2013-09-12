<div class="mail-widget">
<img id="mailbox-widget-mail-icon" src="images/mailbox-widget-mail-icon.png" /><h3>Почта</h3>
<div class="clear"></div>
    <form method="post" action="https://passport.yandex.ru/for/okred.ru?mode=auth">
        <div class="mailbox-widget-login-input">
            <label for="b-domik-username" class="label-hide">Логин</label>
            <input name="login" type="text" id="b-domik-username" class="label-over"  tabindex="1"/>
        </div>
        <div class="mailbox-widget-password-input">
            <div id="mailbox-widget-ok-button"></div>
            <label for="b-domik-password" class="label-hide">Пароль</label>
            <input type="hidden" name="retpath" value="http://mail.yandex.ru/for/okred.ru">
            <input name="passwd" type="password" id="b-domik-password" class="label-over"  tabindex="2" />	
            <input type="submit" name="In" value="Войти" style="display: none;" /> 
        </div>
        <div class="mailbox-widget-rememberme-input">
            <a href="" class="ztooltip-w" original-title="Вам не придется вводить логин и пароль каждый раз"></a>
            <input type="checkbox" checked="" value="yes" name="twoweeks" class="zcheck" id="b-domik-permanent" tabindex="4">
            <input type="checkbox" name="twoweeks" value="yes" style="display: none;" />
            <label for="b-domik-permanent"><div id="zcheckbox"></div><div class="zcheck-label">запомнить меня</div></label>
        </div>
        <div class="mailbox-widget-register-forget">
            <a id="zforgotpwd" href="#" class="ztooltip-w" original-title="Пройдите несколько простых шагов, чтобы восстановить пароль">Забыли пароль?</a>
            <a id="zregister" href="#" class="ztooltip-n" original-title="Регистрация займет всего минуту">Регистрация</a>
        </div>
        <div class="mailbox-widget-signinwith">
        <p>Войти при помощи:</p>
            <a id="signinwith-help" class="ztooltip-w" original-title="Вы можете авторизоваться при помощи Вашей учетной записи на другом сайте" href="#"></a>
            <a id="signin-vkontakte" class="ztooltip-s" original-title="ВКонтакте" href="#"></a>
            <a id="signin-facebook" class="ztooltip-s" original-title="Facebook" href="#"></a>
            <a id="signin-twitter" class="ztooltip-s" original-title="Twitter" href="#"></a>
            <a id="signin-mailru" class="ztooltip-s" original-title="Mail.ru" href="#"></a>
            <a id="signin-google" class="ztooltip-s" original-title="Google" href="#"></a>
            <a id="signin-odnoklassniki" class="ztooltip-s" original-title="Одноклассники" href="#"></a>                               
        </div>
    </form>
</div>