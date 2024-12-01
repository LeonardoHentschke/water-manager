export const fallbackProductsIds = [
    {
       "id" : "5",
       "productid" : "000006",
       "description" : "Número de quedas de luz na última hora",
       "type" : "INT",
       "example" : "10",
       "validateexpression" : "[0-9]+"
    },
    {
       "id" : "1",
       "productid" : "000001",
       "description" : "Sensor de presença de água entrada edificação",
       "type" : "LOGIC",
       "example" : "1 - tem, 0 - não tem",
       "validateexpression" : "^(0|1)$"
    },
    {
       "id" : "3",
       "productid" : "000003",
       "description" : "Sensor de presença de água na cisterna",
       "type" : "LOGIC",
       "example" : "1 - tem, 0 - não tem",
       "validateexpression" : "^(0|1)$"
    },
    {
       "id" : "4",
       "productid" : "000004",
       "description" : "Sensor de presença de água na caixa de água",
       "type" : "LOGIC",
       "example" : "1 - tem, 0 - não tem",
       "validateexpression" : "^(0|1)$"
    },
    {
       "id" : "6",
       "productid" : "000005",
       "description" : "Animal solto na via",
       "type" : "TEXT",
       "example" : "bla, bla bla...",
       "validateexpression" : ""
    },
    {
       "id" : "2",
       "productid" : "000002",
       "description" : "Sensor de pressão da água entrada edificação",
       "type" : "FLOAT",
       "example" : "53.2",
       "validateexpression" : "^[-+]?\d*\.?\d*$"
    }
];