FROM node:20-slim

WORKDIR /app

RUN apt-get update -y && apt-get install -y openssl && rm -rf /var/lib/apt/lists/*

COPY package.json ./
COPY tsconfig.json ./
RUN npm install --legacy-peer-deps

COPY prisma ./prisma/
RUN npx prisma generate

COPY src ./src

EXPOSE 3000

CMD ["npm", "run", "start:dev"]
