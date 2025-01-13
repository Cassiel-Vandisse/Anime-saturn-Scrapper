# Utilizza l'immagine base Python 3.11 slim
FROM python:3.11-slim

# Mantieni l'immagine aggiornata e installa le dipendenze necessarie
RUN apt-get update && apt-get install -y \
    firefox-esr \
    wget \
    curl \
    unzip \
    libnss3 \
    iputils-ping \
    libnss3-tools \
    libxss1 \
    libappindicator3-1 \
    fonts-liberation \
    libasound2 \
    libatk1.0-0 \
    libcups2 \
    libgtk-3-0 \
    libx11-xcb1 \
    libxcomposite1 \
    && apt-get clean

# Installa geckodriver (versione compatibile con Firefox ESR)
# Usa il giusto geckodriver in base all'architettura
RUN uname -m && \
    if [ "$(uname -m)" = "x86_64" ]; then \
        wget -q "https://github.com/mozilla/geckodriver/releases/download/v0.33.0/geckodriver-v0.33.0-linux64.tar.gz"; \
    elif [ "$(uname -m)" = "aarch64" ]; then \
        wget -q "https://github.com/mozilla/geckodriver/releases/download/v0.33.0/geckodriver-v0.33.0-linux64.tar.gz"; \
    fi && \
    tar -xzf geckodriver-v0.33.0-linux64.tar.gz -C /usr/local/bin && \
    chmod +x /usr/local/bin/geckodriver


# Imposta Python come predefinito e installa le librerie richieste
RUN pip install --no-cache-dir \
    selenium \
    mysql-connector-python

# Directory di lavoro nel container
WORKDIR /app

# Copia i file del progetto nel container
COPY . .

# Comando predefinito per avviare il container
CMD ["python", "Anime_Saturn_scarpper.py"]