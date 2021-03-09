FROM nginx:alpine

RUN apk --update add --no-cache supervisor

COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord-web.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]