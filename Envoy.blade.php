@servers(['web' => 'root@cms.ege-repetitor.ru'])

@task('deploy')
    cd /home/egecms
    git pull github master
    php artisan config:cache
    php artisan route:cache
@endtask

@task('update_shared')
    cd /home/egecms
    composer update ege-shared
@endtask

@task('gulp')
    cd /home/egecms
    gulp --production
@endtask

@task('stash_and_pull')
    cd /home/egecms
    git stash
    git pull github master
@endtask

@task('cache')
    cd /home/egecms
    php artisan config:cache
    php artisan route:cache
@endtask

@task('migrate')
    cd /home/egecms
    php artisan migrate --force
@endtask

@task('stash')
    cd /home/egecms
    git stash
@endtask
