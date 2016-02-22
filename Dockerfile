FROM octohost/php5:5.5

ADD . /srv/www

EXPOSE 80

CMD service php5-fpm start && nginx
