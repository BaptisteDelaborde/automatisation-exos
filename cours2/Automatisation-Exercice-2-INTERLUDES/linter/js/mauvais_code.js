function test() {
    const a = 1;
    const b = 2;
    const c = a + b;
    return c;
}

const result = test();
console.log(
    'Le résultat de ma fonction test est : ' + result + ' ! '
    + 'La suite de ce message est inutilement long, '
    + 'et ne devrais pas être sur une seul ligne car c\'est illisible. '
    + 'C\'est une mauvaise pratique.'
);