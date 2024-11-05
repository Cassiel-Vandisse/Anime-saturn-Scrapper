# Anime Saturn Scrapper

**Anime Saturn Scrapper** è un progetto sperimentale per effettuare scraping dal noto sito *AnimeSaturn*. Questo repository fornisce un sistema completo per raccogliere, archiviare e visualizzare episodi e link ai video in modo intuitivo.

## Struttura del Progetto

Anime Saturn Scrapper è suddiviso in tre moduli principali:

1. **Script di scraping in Python**  
   Uno script per estrarre automaticamente link e titoli degli episodi.
   
2. **Database MySQL**  
   Un database per archiviare i titoli e le URL delle pagine, per facilitare il download successivo dei file multimediali.
   
3. **Interfaccia in PHP**  
   Una semplice interfaccia per visualizzare i contenuti del database, con accesso rapido alle risorse.

## Prossimi Sviluppi

Ecco i prossimi obiettivi per il progetto:

- Implementare uno script per identificare e scaricare i file multimediali in una directory specifica.
- Creare una console web e un set di API per una gestione avanzata.
- Valutare l'integrazione con Docker per una maggiore portabilità e facilità di distribuzione.

## Prerequisiti

### Python
- **Sistema operativo**: Windows
- **Versione**: Python 3 o superiore
- **Librerie necessarie**:  
  - `selenium`
  - `mysql.connector`

### PHP
- Qualsiasi web server che supporti PHP.

### Database MySQL
- Vedi il file di configurazione per creare il database e definire lo schema.

## Installazione

1. Clona il repository:
   ```bash
   git clone https://github.com/tuo-username/anime-saturn-scrapper.git
   cd anime-saturn-scrapperInstalla le librerie Python:
2. Installa i prerequisiti
   ```bash
   pip install -r requirements.txt

3. Configura il database MySQL utilizzando il file di configurazione.

4. Esegui lo script di scraping e accedi all'interfaccia PHP per visualizzare i dati raccolti.


## Supporta il progetto
Se ti piace questo progetto e vuoi supportarlo, puoi offrirmi un caffè! ☕

[![Buy me a coffee](https://img.shields.io/badge/Buy%20Me%20a%20Coffee-donate-yellow?style=flat-square&logo=buy-me-a-coffee)](buymeacoffee.com/CassielVandisse)
