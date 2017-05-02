<?php
/**
 * Created by PhpStorm.
 * User: yiqun
 * Date: 15/4/3
 * Time: 下午4:08
 */

namespace api\components;

use api\modules\v1\models\CacheManager\BlogItemCacheManager;
use api\modules\v1\models\CacheManager\BlogItemReviewCacheManager;
use api\modules\v1\models\CacheManager\CategoryCacheManager;
use api\modules\v1\models\CacheManager\EventCacheManager;
use api\modules\v1\models\CacheManager\EventReviewCacheManager;
use api\modules\v1\models\CacheManager\HobbyCacheManager;
use api\modules\v1\models\CacheManager\InviteCacheManager;
use api\modules\v1\models\CacheManager\LocationCacheManager;
use api\modules\v1\models\CacheManager\UserEventCacheManager;
use Yii;

class CacheManager {
        public static function initCache()
        {
            CategoryCacheManager::initCategoryListCache();
            EventCacheManager::initEventListCache();
            EventReviewCacheManager::initEventReviewListCache();
           // HobbyCacheManager::initHobbyListCache();
            LocationCacheManager::initLocationListCache();
            BlogItemCacheManager::initBlogItemListCache();
            BlogItemReviewCacheManager::initBlogItemReviewListCache();
            InviteCacheManager::initInviteListCache();
        }
}