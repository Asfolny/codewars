using System.Linq;

public static class Kata
{
    public static object[] RemoveEveryOther(object[] arr)
    {
        return arr.Where((_, idx) => idx % 2 == 0).ToArray();
    }
}
