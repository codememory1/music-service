FROM node:18.10-alpine

WORKDIR /usr/src/frontend/public

RUN apk add --update nodejs npm

COPY frontend/public/ .

RUN npm install
RUN npm run build

CMD npm run build