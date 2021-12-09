FROM nginx
ADD /docker/config/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/rd-docker