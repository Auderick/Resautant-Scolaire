// menuSemaine.js
const menuData = {
    "semaines": [
        {
            "id": 1,
            "date": "05 au 09 avril 2025",
            "jours": {
                "lundi": {
                    "entree": { "nom": "Carottes râpées", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "Filet de poulet, riz aux légumes", "emoji": "🍗", "allergenes": ["crème"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍎", "bio": true, "local": true }
                },
                "mardi": {
                    "entree": { "nom": "Concombres à la crème", "emoji": "🥗", "allergenes": ["crème"] },
                    "plat_principal": { "nom": "Sauté de veau, purée de céleri rave", "emoji": "🍗", "local": true },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "accompagnement": { "nom": "", "emoji": "🥕", "bio": true },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Mousse au chocolat maison", "emoji": "🍮", "allergenes": ["oeuf"] }
                },
                "jeudi": {
                    "entree": { "nom": "", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "", "emoji": "🐟", "allergenes": ["", ""] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "accompagnement": { "nom": "", "emoji": "🍚" },
                    "fromage_laitage": { "nom": "", "emoji": "🧀", "allergenes": [""] },
                    "dessert": { "nom": "", "emoji": "🥝", "bio": false }
                },
                "vendredi": {
                    "entree": { "nom": "Betteraves vinaigrette", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "Cabillaud sauce citronée, pommes vapeur et haricots verts", "emoji": "🐟", "local": false, "allergenes": ["poisson", "gluten"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍎", "bio": true }
                }
            }
        },
        {
            "id": 2,
            "date": "12 au 16 mai 2025",
            "jours": {
                "lundi": {
                    "entree": { "nom": "Tomate vinaigrette", "emoji": "🍅", "local": true },
                    "plat_principal": { "nom": "escalope de dinde au basilic, pâtes et julienne de légumes", "emoji": "🍗", "local": true, "allergenes": ["crème", "gluten"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍎", "bio": true }
                },
                "mardi": {
                    "entree": { "nom": "Céleri rémoulade", "emoji": "🥗", "allergenes": ["moutarde"] },
                    "plat_principal": { "nom": "Lasagnes bolognaise, Salade", "emoji": "🍝", "allergenes": ["gluten", "lait"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Riz au lait", "emoji": "🍚", "allergenes": ["lait"], "bio": false }
                },
                "jeudi": {
                    "entree": { "nom": "Radis vinaigrette", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "", "emoji": "🐟", "allergenes": [""] },
                    "option_vegetarienne": { "nom": "Gratin de courgettes et pommes de terre au fromage", "emoji": "🥬", "allergenes": ["lait"] },
                    "accompagnement": { "nom": "", "emoji": "🥔", "allergenes": [""] },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍊" }
                },
                "vendredi": {
                    "entree": { "nom": "Salade de pâtes à la feta", "emoji": "🥗", "allergenes": ["gluten", "lait"] },
                    "plat_principal": { "nom": "Rôti de porc, tomate provençale et pommes duchesse", "emoji": "🍳", "allergenes": [""], "local": true },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Poire pochée au sirop", "emoji": "🍌", "bio": true }
                }
            }
        },
        {
            "id": 3,
            "date": "19 au 23 mai 2025",
            "jours": {
                "lundi": {
                    "entree": { "nom": "Terrine forestière", "emoji": "🥗", "local": false, "allergenes": [""] },
                    "plat_principal": { "nom": "Sauté de boeuf à la provençale, polenta et petits pois", "emoji": "🍗", "allergenes": ["gluten"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🥛", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍊", "allergenes": ["", ""] }
                },
                "mardi": {
                    "entree": { "nom": "Taboulé", "emoji": "🥗", "local": false, "allergenes": ["gluten"] },
                    "plat_principal": { "nom": "Longe de porc à l'estragon, carottes et pommes de terre sautées", "emoji": "🥩", "allergenes": ["", ""] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🥛", "allergenes": ["lait"] },
                    "dessert": { "nom": "Oeuf au lait", "emoji": "🍮", "bio": false, "allergenes": ["lait", "œuf"] }
                },
                "jeudi": {
                    "entree": { "nom": "Champignon à la crème", "emoji": "🍄", "local": true, "allergenes": ["crème"] },
                    "plat_principal": { "nom": "", "emoji": "🥘", "allergenes": [""] },
                    "option_vegetarienne": { "nom": "Parmentier de lentilles et patates douces", "emoji": "🥬", "allergenes": ["lait"] },
                    "fromage_laitage": { "nom": "Fromage ou Yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍊", "local": true }
                },
                "vendredi": {
                    "entree": { "nom": "Poireau vinaigrette", "emoji": "🥗" },
                    "plat_principal": { "nom": "filet de poisson beurre blanc, Riz et haricots beurre", "emoji": "🐟", "allergenes": ["crème"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Salade de fruits de saison", "emoji": "🍉", "bio": true }
                }
            }
        },
        {
            "id": 4,
            "date": "26 au 30 mai 2025",
            "jours": {
                "lundi": {
                    "entree": { "nom": "Salade verte parisienne (jambon, emmental)", "emoji": "🥗", "local": false, "allergenes": ["lait", ""] },
                    "plat_principal": { "nom": "Rougail de saucisse, riz basmati", "emoji": "🍛", "local": false },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍊", "bio": true }
                },
                "mardi": {
                    "entree": { "nom": "Duo de saucisson et cornichons", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "Jambon grill sauce au porto, purée de pommes de terre et céleri poêlé", "emoji": "🐟", "allergenes": ["", "crème"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍒", "allergenes": ["", ""] }
                },
                "jeudi": {
                    "entree": { "nom": "", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "", "emoji": "🐟", "allergenes": ["", ""] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "", "emoji": "🧀", "allergenes": [""] },
                    "dessert": { "nom": "", "emoji": "🍒", "allergenes": ["", ""] }
                },
                "vendredi": {
                    "entree": { "nom": "Salade composée", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "Merlu sauce du Chef, tagliatelles et poêlée de légumes", "emoji": "🥘", "allergenes": ["poisson", "crème"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Pomme au four", "emoji": "🍎", "bio": true }
                }
            }
        },
        {
            "id": 5,
            "date": "02 au 06 juin 2025",
            "jours": {
                "lundi": {
                    "entree": { "nom": "Salade de concombres et ciboulette", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "Sauté de dinde au paprika, boulgour et épinards ", "emoji": "🍗", "allergenes": ["gluten", "crème"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🥛", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍋", "allergenes": ["", ""] }
                },
                "mardi": {
                    "entree": { "nom": "salade pièmontaise", "emoji": "🥗", "local": false },
                    "plat_principal": { "nom": "Boeuf bourguignon, coquillettes et carottes", "emoji": "🥩", "allergenes": ["gluten"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🥛", "allergenes": ["lait"] },
                    "dessert": { "nom": "Flan caramel", "emoji": "🍮", "allergenes": ["lait", "œuf"] }
                },
                "jeudi": {
                    "entree": { "nom": "Salade de betteraves", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "", "emoji": "🍛" },
                    "option_vegetarienne": { "nom": "Lasagnes aux légumes et béchamel", "emoji": "🥬", "allergenes": ["lait", "gluten"] },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🥛", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍊", "allergenes": ["", ""] }
                },
                "vendredi": {
                    "entree": { "nom": "Macédoine de légumes mayonnaise", "emoji": "🥗", "local": true, "allergenes": ["", "moutarde"] },
                    "plat_principal": { "nom": "Poisson du marché à la dieppoise, riz pilaf et poêlée de légumes", "emoji": "🥧", "allergenes": ["crustacés", "poisson", "crème"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Mousse au chocolat maison", "emoji": "🍫", "allergenes": ["œuf"] }
                }
            }
        },
        {
            "id": 6,
            "date": "09 au 13 juin 2025",
            "jours": {
                "lundi": {
                    "entree": { "nom": "Salade composée", "emoji": "🥗", "local": true },
                    "plat_principal": { "nom": "Poulet rôti et son jus à l'oignon, haricots verts et frites", "emoji": "🍗", "local": true },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🥛", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🥝", "bio": true }
                },
                "mardi": {
                    "entree": { "nom": "Carottes râpées vinaigrette à l'orange", "emoji": "🥗", "allergenes": ["moutarde"] },
                    "plat_principal": { "nom": "Tomate farcie, riz", "emoji": "🥘", "allergenes": [""] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🥛", "allergenes": ["lait"] },
                    "dessert": { "nom": "Tarte aux poires", "emoji": "🍓", "allergenes": ["gluten", "œuf"], "local": true }
                },
                "jeudi": {
                    "entree": { "nom": "Salade aux fonds d'artichauts", "emoji": "🥗", "local": false },
                    "plat_principal": { "nom": "Sauté de porc charcutière, pâtes et brocolis", "emoji": "🐟", "allergenes": ["crème", "gluten"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Fruit de saison", "emoji": "🍎", "bio": true }
                },
                "vendredi": {
                    "entree": { "nom": "Coleslow (carottes, chou blanc, mayonnaise)", "emoji": "🥗", "local": true, "allergenes": ["moutarde"] },
                    "plat_principal": { "nom": "Filet de poisson meunière, gratin de chou-fleur", "emoji": "🐟", "local": false, "allergenes": ["poisson", "lait", "gluten"] },
                    "option_vegetarienne": { "nom": "", "emoji": "🥬" },
                    "fromage_laitage": { "nom": "Fromage ou yaourt", "emoji": "🧀", "allergenes": ["lait"] },
                    "dessert": { "nom": "Clafoutis aux cerises", "emoji": "🍒", "allergenes": ["gluten", "œuf", "lait"] }
                }
            }
        }
    ]
};
