# Poker Compare

This is a simple app to compare two poker hands.

## Installation

> You need Docker and Docker Compose installed

Clone the repository and run 

```bash
docker compose up -d
```

This will start a web server with php8.

You can access the web app at https://localhost

or run the command from within the `frankenphp` container.

```bash
bin/console app:poker-hand <firstHand> <secondHand>
```

