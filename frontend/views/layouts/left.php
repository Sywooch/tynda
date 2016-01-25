<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 06.08.2015
 * Time: 12:26
 */
use yii\helpers\Url;
use frontend\widgets\CategJob;
use frontend\widgets\CategAfisha;
use frontend\widgets\CategPage;
use frontend\widgets\CategNews;
use frontend\widgets\CategPres;
use frontend\widgets\TagsWidget;
//use frontend\widgets\NewsSidebarWidget;
use frontend\widgets\ProfileLeftSidebar;

$show = false;

$path = Url::current();

$is_company = $this->params['is_company'];
$is_doctor = $this->params['is_doctor'];

if(!stristr($path, 'site')){

    if(stristr($path, '/profile/')||stristr($path, '/jobs/')||stristr($path, '/account/')){
        //echo $path;
        if(stristr($path, 'account/')){
            echo ProfileLeftSidebar::showSidebar(0);
        }
        if(stristr($path, 'profile/index')){
            echo ProfileLeftSidebar::showSidebar(1);
        }
        if(stristr($path, 'profile/company')){
            echo ProfileLeftSidebar::showSidebar(2);
        }
        if(stristr($path, 'jobs/job-profile/index')||stristr($path, 'jobs/index')||stristr($path, 'jobs/edu')||stristr($path, 'jobs/exp')){
            echo ProfileLeftSidebar::showSidebar(4);
        }
        if(stristr($path, 'jobs/resume/create') || stristr($path, 'jobs/resume/update') || stristr($path, 'jobs/resume/my-resume')){
            echo ProfileLeftSidebar::showSidebar(3);
        }
        if(stristr($path, 'jobs/vacancy/create') || stristr($path, 'jobs/vacancy/update') || stristr($path, 'jobs/vacancy/my-vacancy')){
            echo ProfileLeftSidebar::showSidebar(5);
        }
        if(stristr($path, 'jobs/resume/index')||stristr($path, 'jobs/resume/view')){
            echo CategJob::run(\common\widgets\Arrays::getJobCat(),'res');
        }
        if(stristr($path, 'jobs/vacancy/index')||stristr($path, 'jobs/vacancy/view')){
            echo CategJob::run(\common\widgets\Arrays::getJobCat(),'vac');
        }
        //echo NewsSidebarWidget::init();
    }
    if(stristr($path, '/med/doctors')){
        if(stristr($path, '/med/doctors/index')||stristr($path, '/med/doctors/view')){
            echo \frontend\widgets\CategMed::run(\common\widgets\Arrays::getMedCat());
        }
        if(stristr($path, '/med/doctors/update')||stristr($path, '/med/doctors/create')||stristr($path, '/med/doctors/my-serv')){
            echo ProfileLeftSidebar::showSidebar(6);
        }
    }
    if(stristr($path, '/tags/')){
        echo \frontend\widgets\TagsWidget::init();
    }

    if(stristr($path, '/goods')){
        if(stristr($path, '/goods/update')||stristr($path, '/goods/create')||stristr($path, '/goods/my-ads')){
            echo ProfileLeftSidebar::showSidebar(8);
        }
        if(stristr($path, '/goods')||stristr($path, '/goods')){
            echo \frontend\widgets\CategGoodsVMenu::run();
            echo \frontend\widgets\TagsWidget::init();
        }

    }
    if(stristr($path, '/service')||stristr($path, '/set-service')){
        if(stristr($path, '/service/update')||stristr($path, '/service/create')||stristr($path, '/service/my-ads')){
            echo ProfileLeftSidebar::showSidebar(9);
        }
        if(stristr($path, '/service')){
            echo \frontend\widgets\CategServiceVMenu::run();
            echo \frontend\widgets\TagsWidget::init();
        }
        if(stristr($path, '/set-service')){
            echo \frontend\widgets\CategSetServiceVMenu::run();
            echo \frontend\widgets\TagsWidget::init();
        }
    }

    if(stristr($path, '/realty')){
        if(stristr($path, '/realty/sale/update')||stristr($path, '/realty/sale/create')||stristr($path, '/realty/sale/my-ads')){
            echo ProfileLeftSidebar::showSidebar(10);
        }
        if(stristr($path, '/realty/rent/update')||stristr($path, '/realty/rent/create')||stristr($path, '/realty/rent/my-ads')){
            echo ProfileLeftSidebar::showSidebar(11);
        }
        if(stristr($path, '/realty/sale')){
            echo \frontend\widgets\CategRealtySaleVMenu::run();
            echo \frontend\widgets\TagsWidget::init();
        }
        if(stristr($path, '/realty/rent')){
            echo \frontend\widgets\CategRealtyRentVMenu::run();
            echo \frontend\widgets\TagsWidget::init();
        }
    }
    if(stristr($path, '/afisha')){
        echo \frontend\widgets\CategAfisha::run();
        echo \frontend\widgets\TagsWidget::init();
    }
    if(stristr($path, '/news')){
            echo \frontend\widgets\CategNews::run();
            echo \frontend\widgets\TagsWidget::init();
    }
    if(stristr($path, '/page')){
        echo \frontend\widgets\CategPage::run();
        echo \frontend\widgets\TagsWidget::init();
    }
    if(stristr($path, '/forum')){
        echo \frontend\widgets\CategForum::run();
        echo \frontend\widgets\TagsWidget::init();
    }
    if(stristr($path, '/letters')){
        if(stristr($path, '/letters/letters/my-letters')||stristr($path, '/letters/letters/create')||stristr($path, '/letters/letters/update')){
            echo ProfileLeftSidebar::showSidebar(7);
        }
        echo \frontend\widgets\CategLetters::run();
        echo \frontend\widgets\TagsWidget::init();
    }
    /*
    if(stristr($path, 'profile/user-profile/update')){
        echo ProfileLeftSidebar::showSidebar(7);
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'profile/user-profile/my-photo')){
        echo ProfileLeftSidebar::showSidebar(6);
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'profile/user-profile/edit-photo')){
        echo ProfileLeftSidebar::showSidebar(6);
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'users/messages')){
        echo ProfileLeftSidebar::showSidebar(5);
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'users/index')){
        echo ProfileLeftSidebar::showSidebar(1);
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'users/profile')){
        echo ProfileLeftSidebar::showSidebar(3);
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'users/friends')){
        echo ProfileLeftSidebar::showSidebar(3);
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'presentations')){
        echo CategPres::init();
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'tests/default')||stristr($path, 'tests/result')){
        echo ProfileLeftSidebar::showSidebar(4);
    }
    if(stristr($path, 'tests')){
        echo CategTest::init();
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'news')){
        echo CategNews::init();
        echo TagsWidget::init();
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'page')){
        echo CategPage::init();
        echo TagsWidget::init();
        echo NewsSidebarWidget::init();
    }
    if(stristr($path, 'tags')){
        echo TagsWidget::init();
        echo NewsSidebarWidget::init();
    }

*/
    //echo NewsSidebarWidget::init();

    $show = true;

}