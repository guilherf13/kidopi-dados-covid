# Use a base image with Node.js
FROM node:20-alpine

ARG user=gui
ARG uid=1002

WORKDIR /var/www

COPY package*.json ./

RUN npm install

# Criação de usuário e ajuste de permissões
RUN mkdir -p /var/www /home/${user} \
    && id -u ${user} || adduser -D -u ${uid} ${user} \
    && chown -R ${user}:${user} /home/${user} /var/www

EXPOSE 5173

USER ${user}

# Comando padrão para iniciar o servidor
CMD ["npm", "run", "dev", "--", "--host"]
