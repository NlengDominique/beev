# Analyse de flotte de véhicules électriques - Évaluation Développeur Full-Stack

## Aperçu

Concevez et implémentez une petite application full-stack pour aider les gestionnaires de flotte à surveiller l’efficacité et l’impact environnemental de leur flotte de véhicules électriques. Ce projet doit démontrer votre capacité à écrire un code propre et bien structuré tout en résolvant des problèmes réels.

## Solution attendue

- Nous souhaitons que vous conserviez l’organisation fournie, donc **ne divisez pas** votre code en différents projets.  
- Nous attendons une solution qui puisse fonctionner sans que nous ayons à effectuer de modifications ou de débogage : assurez-vous que votre projet **fonctionne dès le départ**.  
- Les commandes listées doivent suffire à lancer le projet et à exécuter le seeder.  
- **Important** : privilégiez la qualité du code à la quantité de fonctionnalités. Il est acceptable de simuler certaines données ou fonctionnalités, mais documentez les hypothèses que vous faites.  

## Directives sur l’utilisation de l’IA

Bien que les outils d’IA puissent être des ressources utiles pour apprendre, une dépendance excessive à du code généré par l’IA pour cette évaluation va à l’encontre de son objectif et **nuira à votre candidature**.  
Ce test évalue vos capacités de résolution de problèmes, vos choix techniques et vos pratiques de codage, pas votre capacité à générer du code automatiquement.  

Lors de la phase de revue, soyez prêt à :  

- Discuter en direct de votre implémentation  
- Répondre à des questions sur vos choix techniques  
- Effectuer éventuellement des modifications en temps réel sur votre code  

## Délais et soumission

- **Durée** : 3 jours  
- **Effort attendu** : 4 à 5 heures  
- **Méthode de soumission** : Dépôt GitHub privé  

## Exigences du projet

### 1. Backend (NestJS)

#### Modèle de données

L’application suivra les véhicules avec les propriétés suivantes :  

- ID (uuid)  
- Marque (string)  
- Modèle (string)  
- Capacité de la batterie (kWh)  
- Niveau de charge actuel (%)  
- Statut (enum : available, charging, in_use)  
- Dernière mise à jour (timestamp)  
- Consommation énergétique moyenne (kWh/100km)  
- Type (BEV/ICE) – _BEV = Véhicule 100% électrique, ICE = moteur thermique_  
- Émissions *gco2_km* – _grammes de CO2 par kilomètre_  

**Source de données** : initialisez la base de données avec le fichier `data/cars.csv` (fourni dans le dépôt du projet).  

#### Endpoints API

1. **Gestion des véhicules**  
   - GET /vehicles – Lister tous les véhicules avec pagination et filtrage  
   - POST /vehicles – Ajouter un nouveau véhicule  
   - GET /vehicles/:id – Obtenir les détails d’un véhicule  
   - PUT /vehicles/:id – Mettre à jour un véhicule  
   - DELETE /vehicles/:id – Supprimer un véhicule  

2. **Analytique**  
   - GET /analytics/fleet-efficiency  
     - Consommation énergétique moyenne selon les modèles  
     - Comparaison des émissions entre BEV et ICE  
   - GET /analytics/fleet-composition  
     - Répartition BEV vs ICE  
   - GET /analytics/fleet-operational  
     - Taux de disponibilité actuel (% de véhicules disponibles)  
     - Nombre de véhicules en charge vs en utilisation  

#### Spécifications techniques

- Utiliser [NestJS](https://docs.nestjs.com/) comme framework backend  
- Utiliser [TypeORM](https://github.com/typeorm/typeorm) pour les interactions avec la base de données  
- Mettre en place la validation des requêtes avec [class-validator](https://docs.nestjs.com/pipes#class-validator)  
- Ajouter un cache Redis pour les endpoints analytiques  
- Inclure un middleware de gestion des erreurs  
- Écrire des [tests unitaires](https://vitest.dev/) pour les services  
- Ajouter des [tests end-to-end](https://playwright.dev/) pour les endpoints critiques  

---

### 2. Frontend (React)

#### Fonctionnalités

1. **Tableau de bord**  
   - Statistiques globales de la flotte  
   - Statut de la flotte  
   - Indicateurs d’impact environnemental  

2. **Gestion des véhicules**  
   - Vue liste avec tri et filtrage  
   - Formulaires d’ajout/modification de véhicules  

3. **Bonus :** Visualisation des données d’analytique à partir des endpoints  

#### Spécifications techniques

- Utiliser TypeScript  
- Implémenter avec les composants [shadcn/ui](https://ui.shadcn.com/)  
- Styliser avec [Tailwind CSS](https://tailwindcss.com/docs)  
- Utiliser [React Query](https://tanstack.com/query/latest) pour la gestion des données  
- Inclure des tests unitaires pour les composants clés  
- Implémenter des *error boundaries*  
- Ajouter des états de chargement (*loading states*)  

---

## Points bonus

- Implémentation de monitoring/logging  
- Stratégies de cache avancées  
- Optimisations de performance  
- Mise en place d’une CI  
- Fonctionnalités supplémentaires pertinentes  

---

## Critères d’évaluation

Nous recherchons :  

- Un code propre et maintenable  
- Une bonne approche de résolution de problèmes  
- Le sens du détail  
- La capacité d’apprentissage  
- La prise de décisions techniques  
- Une bonne gestion du temps  

---

# Guide d’installation du projet

## Prérequis

- Docker & Docker Compose  
- Node.js 20+  
- pnpm  

## Aperçu des ports des services

| Service       | Port interne | Port externe | URL d’accès             | Description                        |
| ------------- | ------------ | ------------ | ----------------------- | ---------------------------------- |
| Frontend      | 8080         | 8000         | http://localhost:8000   | Application React Frontend          |
| Backend       | 3000         | 3000         | http://localhost:3000   | API Backend NestJS                  |
| Postgres      | 5432         | 5432         | localhost:5432          | Service base de données             |
| PgAdmin       | 80           | 8001         | http://localhost:8001   | Interface de gestion Postgres       |
| Redis         | 6379         | 6379         | localhost:6379          | Base clé-valeur                     |
| Redis Insight | 5540         | 8002         | http://localhost:8002   | Interface de gestion Redis          |

> **Note pour Redis Insight** : utilisez la chaîne de connexion `redis://default@redis:6379`  

---

## Commandes Docker

```bash
# Construire tous les services
docker compose build

# Démarrer tous les services
docker compose up -d

# Voir les logs
docker compose logs -f

# Arrêter les services
docker compose down
```

---

## Workflow de développement

```bash
# Installer toutes les dépendances du workspace
pnpm install

# Exécuter une commande dans un workspace spécifique
pnpm --filter backend VOTRE_COMMANDE
# Ou
pnpm --filter frontend VOTRE_COMMANDE

# Démarrer d’abord le backend
pnpm dev:backend

# Puis démarrer le frontend
pnpm dev:frontend
```

---

## Dépannage

1. Vérifiez que Docker est bien lancé  
2. Vérifiez les versions de pnpm et Docker  
3. Utilisez `docker-compose logs` pour inspecter les problèmes de démarrage des services  

---

## Notes

- Les identifiants par défaut sont configurés pour le développement  
- Changez TOUJOURS les identifiants en production  

---

## FAQ

1. **Q : Où puis-je trouver le fichier cars.csv ?**  
   R : Le fichier est disponible dans le dépôt du projet sous le répertoire `data`.  

2. **Q : Que faire si je ne peux pas compléter toutes les exigences dans les temps ?**  
   R : Concentrez-vous sur la qualité du code plutôt que la quantité. Documentez ce que vous auriez fait avec plus de temps.  