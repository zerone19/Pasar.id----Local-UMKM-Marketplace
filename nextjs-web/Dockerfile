FROM node:20-slim

WORKDIR /app

RUN apt-get update -y && apt-get install -y openssl && rm -rf /var/lib/apt/lists/*

COPY package.json ./
COPY tailwind.config.ts ./
COPY tsconfig.json ./
COPY postcss.config.js ./
RUN npm install

COPY src ./src

EXPOSE 3000

CMD ["npm", "run", "dev"]
