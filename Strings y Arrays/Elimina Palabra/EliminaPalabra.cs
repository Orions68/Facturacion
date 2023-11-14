namespace Elimina_Palabra
{
    internal class EliminaPalabra
    {
        static void Main(string[] args)
        {
            string frase;
            string word;
            int index = 0;
            int counter = 0;
            char seguir = 's';

            while (seguir == 's')
            {
                Console.WriteLine("Este Programa Eliminará una Palabra de una Frase Dada.\n");
                Console.Write("Por Favor Ingresa la Frase: ");
                frase = Console.ReadLine();
                Console.WriteLine();
                Console.Write("Por Favor Ingresa la Palabra a Quitar de la Frase: ");
                word = Console.ReadLine();
                Console.WriteLine();
                for (int i = 0; i < frase.Length; i++)
                {
                    if (frase[i] == word[index])
                    {
                        if (index == word.Length - 1)
                        {
                            if (i - word.Length < 0)
                            {
                                frase = frase.Remove(i - (word.Length - 1), word.Length + 1);
                            }
                            else
                            {
                                frase = frase.Remove(i - word.Length, word.Length + 1);
                            }
                            index = 0;
                            counter++;
                        }
                        else
                        {
                            index++;
                        }
                    }
                }
                Console.WriteLine("La Frase Quedó: {0}, Se Han Eliminado {1} Palabras.\n", frase, counter);
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Frase y Palabra a Eliminar, Cualquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                counter = 0;
                index = 0;
                Console.Clear();
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}