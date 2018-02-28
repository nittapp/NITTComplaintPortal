FROM nginx:1.10-alpine

ADD default.conf /etc/nginx/conf.d/default.conf

COPY public /var/www/public