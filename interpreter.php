<?php

/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-18
 * Time: 下午3:15
 */
class User
{
    protected $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getProfilePage()
    {
        //假装这是数据库中拿到的数据
        $profile = '<h2>I like Never Again</h2>';
        $profile .= 'I love all of their songs. My favorite CD:<br/>';
        $profile .= '{{myCD.getTitle}}!!';

        return $profile;
    }
}

class UserCD
{
    protected $user;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getTitle()
    {
        //假装从数据库或者什么地方拿到的$title╮(╯▽╰)╭
        $title = 'title';
        return $title;
    }
}

//解释器,多用于模板系统中,对字符串进行解释处理,解释替换相应内容
class UserCDInterpreter
{
    protected $user;

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getInterpreted()
    {
        $profile = $this->user->getProfilePage();

        if (preg_match_all('/\{\{myCD\.(.*?)\}\}/', $profile, $triggers, PREG_SET_ORDER)) {
            $replacements = [];

            foreach ($triggers as $trigger) {
                $replacements[] = $trigger[1];
            }

            var_dump($triggers);
            $replacements = array_unique($replacements);

            $myCD = new UserCD();
            $myCD->setUser($this->user);

            foreach ($replacements as $replacement) {
                $profile = str_replace("{{myCD.$replacement}}", call_user_func([$myCD, $replacement]), $profile);
            }
        }

        return $profile;
    }
}

$username = 'userA';

$user = new User($username);
$interpreter = new UserCDInterpreter();
$interpreter->setUser($user);

print "<h1>$username's Profile</h1>";
print $interpreter->getInterpreted();