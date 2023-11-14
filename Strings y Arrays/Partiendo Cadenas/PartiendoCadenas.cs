namespace Partiendo_Cadenas
{
    internal class PartiendoCadenas
    {
        static void Main(string[] args)
        {
            string frase;
            string[] result;

            Console.WriteLine("Este Programa Separará Todas las Palabras de una Frase Dada y Dirá Cuanto Mide Cada Una.\n");
            Console.Write("Introduce la Frase: ");
            frase = Console.ReadLine();
            Console.WriteLine();
            result = frase.Split(' ');
            for (int i = 0; i < result.Length; i++)
            {
                Console.WriteLine("La {0}ª Palabra es: {1}, Tiene: {2} Caracteres.\n", i + 1, result[i], result[i].Length);
            }
        }
    }
}