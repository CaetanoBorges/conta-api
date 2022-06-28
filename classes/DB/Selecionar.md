echo (new Selecionar())
    ->select(["name", "surname"])
    ->from("users")
    ->where(["name = 'John'", "city = 'Warsaw'"])
    ->orderBy("date ASC")
    ->limit(10)
    ->getQuery();